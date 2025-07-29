<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberToWords\NumberToWords;
use App\Models\Proposta;
use App\Models\Equipamento;
use App\Models\Infraestrutura;

class OS extends Model
{
    use HasFactory;

    protected $table = 'os'; // Especifica explicitamente o nome da tabela

     protected $fillable = [
        'proposta_id',
        'numero_projeto',
        'numero_relatorio',
        'numero_plano',
        'servico',
        'data_amostragem',
        'observacao',
    ];

    public function proposta()
    {
        return $this->belongsTo(Proposta::class, 'proposta_id');
    }

    public static function buscarComRelacionamentosPorId($id)
    {
        $os = self::with('proposta.empresa', 'proposta.fontesEmissao', 'proposta.grupos.metodologias', 'proposta.servicosCustos')
            ->findOrFail($id);

        $proposta = $os->proposta;

        // Soma dos valores 'total' dos serviços
        $proposta->soma_total_servicos = $proposta->servicosCustos->sum('total');

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('pt_BR');

        $proposta->valor_extenso = $numberTransformer->toWords($proposta->soma_total_servicos);

        // Descrições concatenadas
        $proposta->descricoes_servicos = $proposta->servicosCustos
            ->pluck('descricao')
            ->filter()
            ->implode(', ');

        $proposta->nome_empresa = optional($proposta->empresa)->nome;

        // Equipamentos
        $equipamentoIds = array_filter(explode(',', $proposta->equipamentos));
        $equipamentos = Equipamento::whereIn('id', $equipamentoIds)->get()->toArray();
        $proposta->equipamentos_detalhes = $equipamentos;

        // Infraestruturas
        $infraestruturasIds = array_filter(explode(',', $proposta->infraestruturas));
        $infraestruturas = Infraestrutura::whereIn('conjunto_id', $infraestruturasIds)
            ->orderBy('conjunto_id')
            ->orderBy('ordem')
            ->get()
            ->groupBy('conjunto_id')
            ->toArray();

        $proposta->infraestruturas_detalhes = $infraestruturas;

        // Adiciona a proposta modificada dentro da OS para uso posterior
        $os->proposta_expandida = $proposta;

        return $os;
    }

}

