<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Log;

class DocumentoController extends Controller
{
    public function gerar(Request $request)
    {
        // Garante que a pasta de saída exista
        if (!file_exists(storage_path('app/documentos'))) {
            mkdir(storage_path('app/documentos'), 0777, true);
        }

        // Caminho do template
        $templatePath = storage_path('app/documentos/RelatorioNovo2.docx');
        
        // Verifica se o arquivo existe
        if (!file_exists($templatePath)) {
            return back()->with('error', 'Template não encontrado!');
        }

        try {
            // Processa o template
            $templateProcessor = new TemplateProcessor($templatePath);
            
            // Debug: Mostra todas as variáveis encontradas no template
            $variables = $templateProcessor->getVariables();
            Log::info('Variáveis encontradas no template:', ['variables' => $variables]);
            
            // Debug: Mostra os dados recebidos do formulário
            Log::info('Dados recebidos do formulário:', $request->all());

            // Verifica se todas as variáveis necessárias existem no template
            $requiredVariables = [
                'numeroRelatorio',
                'dadosDoCliente',
                'enderecoEmpresa',
                'cnpj',
                'tecnico1',
                'tecnico2',
                'data'
            ];

            $missingVariables = array_diff($requiredVariables, $variables);
            if (!empty($missingVariables)) {
                Log::error('Variáveis faltando no template:', ['missing' => $missingVariables]);
                return back()->with('error', 'Algumas variáveis não foram encontradas no template: ' . implode(', ', $missingVariables));
            }

            // Substitui os campos
            $templateProcessor->setValue('numeroRelatorio', $request->input('numeroRelatorio'));
            $templateProcessor->setValue('dadosDoCliente', $request->input('dadosDoCliente'));
            $templateProcessor->setValue('enderecoEmpresa', $request->input('enderecoEmpresa'));
            $templateProcessor->setValue('cnpj', $request->input('cnpj'));
            $templateProcessor->setValue('tecnico1', $request->input('tecnico1'));
            $templateProcessor->setValue('tecnico2', $request->input('tecnico2'));
            $templateProcessor->setValue('data', $request->input('data'));

            // Caminho do novo documento
            $outputPath = storage_path('app/documentos/documento-preenchido.docx');

            // Salva o novo documento
            $templateProcessor->saveAs($outputPath);

            // Retorna o arquivo para download
            return response()->download($outputPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            Log::error('Erro ao processar documento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao processar o documento: ' . $e->getMessage());
        }
    }
}
