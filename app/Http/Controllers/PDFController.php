<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF(Request $request, $perfilId)
    {
        // Obter os dados do perfil
        $perfil = DB::table('tabela_perfil')->where('id_perfil', $perfilId)->first();

        // Realizar o JOIN para obter os valores das coletas e os nomes dos parâmetros
        $valoresColetas = DB::table('tabela_valores_coletas')
            ->join('tabela_parametros', 'tabela_valores_coletas.id_parametro', '=', 'tabela_parametros.id_parametro')
            ->where('tabela_valores_coletas.id_perfil', $perfilId)
            ->select('tabela_valores_coletas.numero_coleta', 'tabela_valores_coletas.valor', 'tabela_parametros.nome as nome_parametro', 'tabela_parametros.unidade')
            ->get();

        // Obter os dados do formulário
        $data = $request->all();
        $data['perfilId'] = $perfilId; // Adiciona perfilId aos dados
        $data['perfil'] = $perfil;
        $data['valoresColetas'] = $valoresColetas;

        // Renderizar a view do PDF com os dados
        $html = view('os.pdf', compact('data'))->render();

        $header = '
        <div class="header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 10px 0; margin-bottom: 50px;">
            <div class="header-text" style="text-align: left;">
                <div class="title" style="font-size: 24px; font-weight: bold;">RELATÓRIO TÉCNICO</div>
                <div class="subtitle" style="font-size: 14px; color: gray;">www.chaminesolucoes.com.br</div>
            </div>
        </div>
        <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f2f2f2;">Efluente Atmosférico</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f2f2f2;">Destilaria Rio do Cachimbo Ltda - RT 206/24</th>
                <th style="border: 1px solid #000; padding: 8px; background-color: #f2f2f2;">Página {PAGENO}/{nb}</th>
            </tr>
        </table>';

        $footer = '
        <div class="footer" style="border-top: 1px solid #ddd; text-align: center; font-size: 14px; color: green; margin-top: 20px; width: 100%; background-color: white; padding: 10px 0;">
            <p style="margin: 5px 0; font-size: 18px; color: green; line-height: 1.0; font-family: \'Times New Roman\', Times, serif;">Rua João Gualberto dos Santos, 151 Céu Azul CEP: 31580-500 Belo Horizonte / MG</p>
            <p style="margin: 5px 0; font-size: 18px; color: green; line-height: 1.0; font-family: \'Times New Roman\', Times, serif;">Telefone: +55 31 3031-0406 E-mail: chaminesolucoes@chaminesolucoes.com.br</p>
        </div>';

        $mpdf = new Mpdf();
        $mpdf->SetHTMLHeader($header);
        $mpdf->WriteHTML($html);
        $mpdf->SetHTMLFooter($footer);
        return $mpdf->Output('relatorio.pdf', 'I');
    }
}
