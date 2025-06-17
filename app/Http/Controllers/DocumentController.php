<?php

namespace App\Http\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpWord\Element\Image;
use App\Models\TabelaPerfil;
use App\Models\ValorColeta;
use App\Models\Parametro;

class DocumentController extends Controller
{
    public function showForm()
    {
        // Caminho absoluto para a pasta de templates
        $templatesPath = storage_path('app/templates');
        
        // Verifica se o diretório existe
        if (!File::exists($templatesPath)) {
            File::makeDirectory($templatesPath, 0755, true);
        }

        // Lista todos os arquivos .docx da pasta de templates
        $templates = collect(File::files($templatesPath))
            ->filter(function ($file) {
                return $file->getExtension() === 'docx';
            })
            ->map(function ($file) {
                return $file->getFilenameWithoutExtension();
            })
            ->values();

        return view('documents.form', compact('templates'));
    }

    public function getPlaceholders(Request $request)
    {
        $templateName = $request->input('template_name');
        $templatePath = storage_path('app/templates/' . $templateName . '.docx');

        Log::info('Iniciando busca de placeholders', [
            'template' => $templateName,
            'caminho' => $templatePath
        ]);

        if (!File::exists($templatePath)) {
            Log::error('Template não encontrado', ['caminho' => $templatePath]);
            return response()->json(['error' => 'Template não encontrado'], 404);
        }

        try {
            // Carrega o documento
            $phpWord = IOFactory::load($templatePath);
            Log::info('Documento carregado com sucesso');
            
            // Extrai o texto do documento
            $text = '';
            $totalElements = 0;
            $textElements = 0;

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    $totalElements++;
                    if ($element instanceof Text) {
                        $textElements++;
                        $elementText = $element->getText();
                        $text .= $elementText . ' ';
                        Log::debug('Texto encontrado', ['texto' => $elementText]);
                    } elseif ($element instanceof TextRun) {
                        foreach ($element->getElements() as $textElement) {
                            if ($textElement instanceof Text) {
                                $textElements++;
                                $elementText = $textElement->getText();
                                $text .= $elementText . ' ';
                                Log::debug('Texto em TextRun encontrado', ['texto' => $elementText]);
                            }
                        }
                    }
                }
            }

            Log::info('Processamento de elementos concluído', [
                'total_elements' => $totalElements,
                'text_elements' => $textElements
            ]);

            // Encontra todos os placeholders no formato ${placeholder}
            // Usando uma expressão regular mais precisa
            $pattern = '/\${([a-zA-Z0-9_]+)}/';
            preg_match_all($pattern, $text, $matches);
            
            // Log de todos os matches encontrados
            Log::info('Matches encontrados', [
                'total_matches' => count($matches[0]),
                'matches_completos' => $matches[0],
                'placeholders' => $matches[1]
            ]);
            
            // Remove duplicatas e ordena
            $placeholders = array_unique($matches[1]);
            sort($placeholders);

            // Log dos placeholders finais
            Log::info('Placeholders processados', [
                'total' => count($placeholders),
                'placeholders' => $placeholders,
                'texto_completo' => $text
            ]);

            // Verifica se há texto que parece placeholder mas não está no formato correto
            $incorrectPattern = '/\${[^}]*[^a-zA-Z0-9_][^}]*}/';
            preg_match_all($incorrectPattern, $text, $incorrectMatches);
            
            if (!empty($incorrectMatches[0])) {
                Log::warning('Possíveis placeholders incorretos encontrados', [
                    'incorrect_matches' => $incorrectMatches[0]
                ]);
            }

            return response()->json(['placeholders' => $placeholders]);
        } catch (\Exception $e) {
            Log::error('Erro ao processar template', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao ler template: ' . $e->getMessage()], 500);
        }
    }

    public function generateDocument(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'template_name' => 'required|string',
            'data' => 'required|array',
            'imagens' => 'nullable|array',
            'imagens.*' => 'nullable|image|mimes:jpeg,png,gif|max:2048'
        ]);

        Log::info('Iniciando geração de documento', [
            'template' => $validated['template_name'],
            'dados' => $validated['data']
        ]);

        // Caminho do template
        $templatePath = storage_path('app/templates/' . $validated['template_name'] . '.docx');
        
        // Verifica se o template existe
        if (!file_exists($templatePath)) {
            Log::error('Template não encontrado', ['caminho' => $templatePath]);
            return response()->json(['error' => 'Template não encontrado'], 404);
        }

        try {
            // Cria uma instância do TemplateProcessor
            $templateProcessor = new TemplateProcessor($templatePath);

            // Processa as imagens
            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $key => $imagem) {
                    if ($imagem) {
                        try {
                            // Gera um nome único para a imagem
                            $imageName = 'temp_' . time() . '_' . $key . '.' . $imagem->getClientOriginalExtension();
                            
                            // Salva a imagem temporariamente usando o método store
                            $tempPath = $imagem->store('temp', 'local');
                            
                            // Obtém o caminho completo do arquivo
                            $fullTempPath = Storage::disk('local')->path($tempPath);

                            Log::info('Tentando processar imagem', [
                                'placeholder' => $key,
                                'caminho' => $fullTempPath,
                                'existe' => file_exists($fullTempPath)
                            ]);

                            // Verifica se o arquivo foi salvo corretamente
                            if (!file_exists($fullTempPath)) {
                                throw new \Exception("Falha ao salvar a imagem temporária");
                            }

                            // Adiciona a imagem ao documento com enquadramento automático
                            $templateProcessor->setImageValue($key, [
                                'path' => $fullTempPath,
                                'width' => 500, // Largura máxima em pixels
                                'height' => 300, // Altura máxima em pixels
                                'ratio' => true, // Mantém a proporção
                                'alignment' => 'center', // Centraliza a imagem
                                'wrappingStyle' => 'square', // Estilo de quebra de texto
                                'positioning' => 'relative' // Posicionamento relativo
                            ]);

                            // Remove o arquivo temporário
                            if (file_exists($fullTempPath)) {
                                unlink($fullTempPath);
                            }

                            Log::info('Imagem processada com sucesso', [
                                'placeholder' => $key,
                                'caminho' => $fullTempPath
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Erro ao processar imagem', [
                                'erro' => $e->getMessage(),
                                'placeholder' => $key,
                                'trace' => $e->getTraceAsString()
                            ]);
                            // Continua o processamento mesmo se uma imagem falhar
                            continue;
                        }
                    }
                }
            }

            // Substitui os placeholders pelos valores do formulário
            foreach ($validated['data'] as $key => $value) {
                Log::debug('Substituindo placeholder', [
                    'placeholder' => $key,
                    'valor' => $value
                ]);
                $templateProcessor->setValue($key, $value);
            }
            $validated['data']['perfil'];

            $idPerfil = $validated['data']['perfil'] ?? null;

            if (!$idPerfil) {
                return response()->json(['error' => 'Perfil não informado'], 400);
            }

            // Buscar o perfil
            $perfil = TabelaPerfil::find($idPerfil);
            if (!$perfil) {
                return response()->json(['error' => 'Perfil não encontrado'], 404);
            }

            //pega os valores do perfil e envia para o word
            foreach ($perfil->getAttributes() as $campo => $valor) {
                $placeholder = $campo;
                $templateProcessor->setValue($placeholder, $valor ?? '');
            }

            //pega os valores de coleta e envia para o word
            $coletasDetalhadas = ValorColeta::getDetalhesPorPerfil($idPerfil);

            foreach ($coletasDetalhadas as $coleta) {
                $parametroSlug = str_replace(' ', '_', strtolower($coleta->parametro_nome));
                $placeholder = "v_{$parametroSlug}_{$coleta->numero_coleta}";

                $templateProcessor->setValue($placeholder, $coleta->valor);
                $templateProcessor->setValue("u_{$parametroSlug}", $coleta->parametro_unidade); // opcional
            }

            $valores = [
                $validated['data']['v_concentração_de_material_particulado_(mg/nm³)_1'] ?? null,
                $validated['data']['v_concentração_de_material_particulado_(mg/nm³)_2'] ?? null,
                $validated['data']['v_concentração_de_material_particulado_(mg/nm³)_3'] ?? null,
            ];

            // Filtra valores nulos e converte para float
            $valoresFiltrados = array_filter($valores, function ($v) {
                return is_numeric($v);
            });

            $media = count($valoresFiltrados) > 0
                ? array_sum($valoresFiltrados) / count($valoresFiltrados)
                : 0;

            $templateProcessor->setValue('media_particulado', number_format($media, 2, ',', ''));

            // Média de concentração de monóxido de carbono (mg/Nm³)
            $valoresCO = [
                $validated['data']['v_concentração_de_monóxido_de_carbono_(mg/nm³)_1'] ?? null,
                $validated['data']['v_concentração_de_monóxido_de_carbono_(mg/nm³)_2'] ?? null,
                $validated['data']['v_concentração_de_monóxido_de_carbono_(mg/nm³)_3'] ?? null,
            ];

            $valoresFiltradosCO = array_filter($valoresCO, fn($v) => is_numeric($v));
            $mediaCO = count($valoresFiltradosCO) > 0 ? array_sum($valoresFiltradosCO) / count($valoresFiltradosCO) : 0;

            // Adiciona ao template
            $templateProcessor->setValue('media_concentracao_monoxido_carbono', number_format($mediaCO, 2, ',', '.'));

            // Gera um nome único para o novo documento
            $newFileName = 'document_' . time() . '.docx';

            // Cria uma resposta de stream para download direto
            return new StreamedResponse(
                function () use ($templateProcessor) {
                    $templateProcessor->saveAs('php://output');
                },
                200,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'Content-Disposition' => 'attachment; filename="' . $newFileName . '"',
                ]
            );

        } catch (\Exception $e) {
            Log::error('Erro ao gerar documento', [
                'erro' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Erro ao gerar documento: ' . $e->getMessage()], 500);
        }
    }
} 