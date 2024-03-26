<?php

namespace App\Listeners\PublicarEspelho;

use App\Events\PublicarEspelhoEvent;
use App\Models\Evento;
use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\Historico\HistoricoEvento;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Historico\HistoricoPromotoria;
use App\Models\Historico\HistoricoUrgenciaAtendimento;
use App\Models\Promotor;
use App\Models\Promotoria;
use App\Models\UrgenciaAtendimento;
use Illuminate\Support\Facades\Log;

class CreateNewHistorico
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PublicarEspelhoEvent $event): void
    {
        $periodoEspelho       = $event->getPeriodoEspelho();
        $promotorias          = Promotoria::all();
        $promotores           = Promotor::all();
        $urgenciaAtendimentos = UrgenciaAtendimento::all();
        $eventos              = Evento::all();

        $historico = Historico::query()->create([
            'periodo_inicio' => $periodoEspelho['periodo_inicio'],
            'periodo_fim'    => $periodoEspelho['periodo_fim'],
        ]);
        $historicoEspelho = HistoricoEspelho::query()->create([
            'periodo_inicio' => $periodoEspelho['periodo_inicio'],
            'periodo_fim'    => $periodoEspelho['periodo_fim'],
            'historico_id'   => $historico->id,
        ]);
        $idNovoHistoricoPromotores = [];
        foreach ($promotores as $promotor) {
            $idNovoHistoricoPromotores[$promotor->id] = HistoricoPromotor::query()->create([
                'nome'          => $promotor->nome,
                'is_substituto' => $promotor->is_substituto,
                'historico_id'  => $historico->id,
            ])->id;
        }
        foreach ($promotorias as $promotoria) {
            HistoricoPromotoria::query()->create([
                'nome'                          => $promotoria->nome,
                'nome_grupo_promotorias'        => $promotoria->nome_grupo_promotorias,
                'municipio'                     => $promotoria->municipio,
                'is_especializada'              => $promotoria->is_especializada,
                'historico_espelho_id'          => $historicoEspelho->id,
                'historico_promotor_titular_id' => $idNovoHistoricoPromotores[$promotoria->promotor_titular_id],
                'historico_id'                  => $historico->id,
            ]);
        }
        foreach ($urgenciaAtendimentos as $urgenciaAtendimento) {
            HistoricoUrgenciaAtendimento::query()->create([
                'periodo_inicio'                  => $urgenciaAtendimento->periodo_inicio,
                'periodo_fim'                     => $urgenciaAtendimento->periodo_fim,
                'historico_promotor_designado_id' => $idNovoHistoricoPromotores[$urgenciaAtendimento->promotor_designado_id],
                'historico_id'                    => $historico->id,
            ]);
        }
        foreach ($eventos as $evento) {
            HistoricoEvento::query()->create([
                'titulo'                          => $evento->titulo,
                'tipo'                            => $evento->tipo,
                'periodo_inicio'                  => $evento->periodo_inicio,
                'periodo_fim'                     => $evento->periodo_fim,
                'historico_promotor_titular_id'   => $idNovoHistoricoPromotores[$evento->promotor_titular_id],
                'historico_promotor_designado_id' => $idNovoHistoricoPromotores[$evento->promotor_designado_id],
                'historico_id'                    => $historico->id,
            ]);
        }
    }
}
