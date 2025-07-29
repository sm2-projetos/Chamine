<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Equipamento;
use App\Models\Infraestrutura;
use NumberToWords\NumberToWords;

class Proposta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_empresa',
        'numero_proposta',
        'servico_solicitado',
        'metodo_utilizado',
        'capacidade_recursos',
        'alteracao_proposta',
        'provedores_externos',
        'propostatxt',
        'apresentacao',
        'objetivo',
        'equipamentos',
        'infraestruturas',
        'observacoes',
        'status',
        'lixeira',
    ];

    protected $casts = [
        'servicos_custos' => 'array',
    ];

    public function os()
    {
        return $this->hasOne(OS::class);
    }

        public function fontesEmissao()
    {
        return $this->hasMany(FonteEmissao::class, 'id_proposta');
    }

    public function servicosCustos()
    {
        return $this->hasMany(ServicoCusto::class, 'id_proposta');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function grupos()
    {
        return $this->hasMany(\App\Models\PropostaGrupo::class, 'proposta_id');
    }
    public static function buscarComRelacionamentosPorStatus($status = null)
    {
        return self::with(['fontesEmissao', 'servicosCustos', 'empresa']) // Inclui o nome da empresa
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get()
            ->map(function ($proposta) {
                // Soma dos valores 'total'
                $proposta->soma_total_servicos = $proposta->servicosCustos->sum('total');

                // Concatenação das descrições
                $proposta->descricoes_servicos = $proposta->servicosCustos
                    ->pluck('descricao')
                    ->filter()
                    ->implode(', ');

                // Acesso ao nome da empresa (opcionalmente adicionar campo direto)
                $proposta->nome_empresa = optional($proposta->empresa)->nome;

                $equipamentoIds = array_filter(explode(',', $proposta->equipamento));

                // 3. Busca os equipamentos correspondentes
                $equipamentos = Equipamento::whereIn('id', $equipamentoIds)->get();

                // 4. Adiciona ao objeto $proposta (sem salvar no banco, só para uso posterior)
                $proposta->equipamentos_detalhes = $equipamentos;

                $proposta->possui_os = OS::where('proposta_id', $proposta->id)->exists() ? 1 : 0;

                return $proposta;
            });
    }

    public static function buscarComRelacionamentosPorId($id)
    {
        $proposta = self::with(['fontesEmissao', 'servicosCustos', 'empresa', 'grupos.metodologias'])
            ->findOrFail($id); // ou ->where('id', $id)->firstOrFail()

        // Soma dos valores 'total'
        $proposta->soma_total_servicos = $proposta->servicosCustos->sum('total');

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('pt_BR');

        $proposta->valor_extenso = $numberTransformer->toWords($proposta->soma_total_servicos); 
        // Concatenação das descrições
        $proposta->descricoes_servicos = $proposta->servicosCustos
            ->pluck('descricao')
            ->filter()
            ->implode(', ');

        // Nome da empresa
        $proposta->nome_empresa = optional($proposta->empresa)->nome;
        
        $equipamentoIds = array_filter(explode(',', $proposta->equipamentos));
                // 3. Busca os equipamentos correspondentes
        $equipamentos = Equipamento::whereIn('id', $equipamentoIds)->get();

        $equipamentos = $equipamentos->toArray();
                // 4. Adiciona ao objeto $proposta (sem salvar no banco, só para uso posterior)
        $proposta->equipamentos_detalhes = $equipamentos;


        $infraestruturasIds = array_filter(explode(',', $proposta->infraestruturas));

        $infraestruturas = Infraestrutura::whereIn('conjunto_id', $infraestruturasIds)
            ->orderBy('conjunto_id')
            ->orderBy('ordem')
            ->get()
            ->groupBy('conjunto_id');

        $infraestruturas = $infraestruturas->toArray();

        $proposta->infraestruturas_detalhes = $infraestruturas;

        return $proposta;
    }

}