<?php

namespace App\Listeners\PublicarEspelho;

use App\Events\PublicarEspelhoEvent;
use App\Models\Evento;
use App\Models\GrupoPromotoria;
use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\Historico\HistoricoEvento;
use App\Models\Historico\HistoricoGrupoPromotoria;
use App\Models\Historico\HistoricoMunicipio;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Historico\HistoricoPromotoria;
use App\Models\Historico\HistoricoUrgenciaAtendimento;
use App\Models\Municipio;
use App\Models\Promotor;
use App\Models\Promotoria;
use App\Models\UrgenciaAtendimento;
use App\Utils\DateConverter;
use Illuminate\Support\Facades\DB;

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
        $periodoEspelho                 = $event->getPeriodoEspelho();
        $municipios                     = Municipio::all();
        $grupoPromotorias               = GrupoPromotoria::all();
        $promotorias                    = Promotoria::all();
        $promotores                     = Promotor::all();
        $urgenciaAtendimentos           = UrgenciaAtendimento::all();
        $eventos                        = Evento::all();
        $novosHistoricoPromotores       = [];
        $novoHistoricoMunicipios        = [];
        $novosHistoricoGrupoPromotorias = [];

        $historicoId      = Historico::query()->create()->id;
        $historicoEspelho = $this->createHistoricoEspelho($periodoEspelho, $historicoId);

        DB::transaction(function () use ($municipios, &$novoHistoricoMunicipios, $historicoId) {
            foreach ($municipios as $municipio) {
                $novoHistoricoMunicipios[$municipio->id] = $this->createHistoricoMunicipios($municipio, $historicoId);
            }
        });
        DB::transaction(function () use ($grupoPromotorias, &$novoHistoricoMunicipios, &$novosHistoricoGrupoPromotorias, $historicoId) {
            foreach ($grupoPromotorias as $grupoPromotoria) {
                $novosHistoricoGrupoPromotorias[$grupoPromotoria->id] = $this->createHistoricoGrupoPromotoria($grupoPromotoria, $novoHistoricoMunicipios, $historicoId);
            }
        });
        DB::transaction(function () use ($promotores, &$novosHistoricoPromotores, $historicoId) {
            foreach ($promotores as $promotor) {
                $novosHistoricoPromotores[$promotor->id] = $this->createHistoricoPromotor($promotor, $historicoId);
            }
        });
        DB::transaction(function () use ($promotorias, $historicoEspelho, &$novosHistoricoPromotores, &$novosHistoricoGrupoPromotorias, $historicoId) {
            foreach ($promotorias as $promotoria) {
                $this->createHistoricoPromotoria($promotoria, $historicoEspelho->id, $novosHistoricoPromotores, $novosHistoricoGrupoPromotorias, $historicoId);
            }
        });
        DB::transaction(function () use ($urgenciaAtendimentos, &$novosHistoricoPromotores, $historicoId) {
            foreach ($urgenciaAtendimentos as $urgenciaAtendimento) {
                $this->createHistoricoUrgenciaAtendimento($urgenciaAtendimento, $novosHistoricoPromotores, $historicoId);
            }
        });
        DB::transaction(function () use ($eventos, &$novosHistoricoPromotores, $historicoId) {
            foreach ($eventos as $evento) {
                $this->createHistoricoEvento($evento, $novosHistoricoPromotores, $historicoId);
            }
        });
    }

    /**
     * @param  array<string>  $periodo
     */
    private function createHistoricoEspelho(array $periodo, int $historicoId): HistoricoEspelho
    {
        return HistoricoEspelho::create([
            'titulo'         => 'Espelho de ' . DateConverter::convertToBrazilianDate($periodo['periodo_inicio']) . ' a ' . DateConverter::convertToBrazilianDate($periodo['periodo_fim']),
            'periodo_inicio' => $periodo['periodo_inicio'],
            'periodo_fim'    => $periodo['periodo_fim'],
            'usuario_id'     => auth()->id(),
            'historico_id'   => $historicoId,
        ]);
    }

    private function createHistoricoMunicipios(Municipio $municipio, int $historicoId): HistoricoMunicipio
    {
        return HistoricoMunicipio::create([
            'nome'         => $municipio->nome,
            'historico_id' => $historicoId,
        ]);
    }

    /**
     * @param  array<HistoricoMunicipio>  $novoHistoricoMunicipios
     */
    private function createHistoricoGrupoPromotoria(GrupoPromotoria $grupoPromotoria, array $novoHistoricoMunicipios, int $historicoId): HistoricoGrupoPromotoria
    {
        return HistoricoGrupoPromotoria::create([
            'nome'                   => $grupoPromotoria->nome,
            'historico_municipio_id' => $novoHistoricoMunicipios[$grupoPromotoria->municipio_id]->id,
            'historico_id'           => $historicoId,
        ]);
    }

    private function createHistoricoPromotor(Promotor $promotor, int $historicoId): HistoricoPromotor
    {
        return HistoricoPromotor::create([
            'nome'          => $promotor->nome,
            'is_substituto' => $promotor->is_substituto,
            'historico_id'  => $historicoId,
        ]);
    }

    /**
     * @param  array<HistoricoPromotor>  $novosHistoricoPromotores
     * @param  array<HistoricoGrupoPromotoria>  $novosHistoricoGrupoPromotorias
     */
    private function createHistoricoPromotoria(Promotoria $promotoria, int $historicoEspelhoId, array $novosHistoricoPromotores, array $novosHistoricoGrupoPromotorias, int $historicoId): void
    {
        HistoricoPromotoria::query()
            ->create([
                'nome'                          => $promotoria->nome,
                'is_especializada'              => $promotoria->is_especializada,
                'historico_espelho_id'          => $historicoEspelhoId,
                'historico_promotor_titular_id' => $novosHistoricoPromotores[$promotoria->promotor_titular_id]->id,
                'historico_grupo_promotoria_id' => $novosHistoricoGrupoPromotorias[$promotoria->grupo_promotoria_id]->id,
                'historico_id'                  => $historicoId,
            ]);
    }

    /**
     * @param  array<HistoricoPromotor>  $novosHistoricoPromotores
     */
    private function createHistoricoUrgenciaAtendimento(UrgenciaAtendimento $urgenciaAtendimento, array $novosHistoricoPromotores, int $historicoId): void
    {
        HistoricoUrgenciaAtendimento::query()->create([
            'periodo_inicio'                  => $urgenciaAtendimento->periodo_inicio,
            'periodo_fim'                     => $urgenciaAtendimento->periodo_fim,
            'historico_promotor_designado_id' => $novosHistoricoPromotores[$urgenciaAtendimento->promotor_designado_id]->id,
            'historico_id'                    => $historicoId,
        ]);
    }

    /**
     * @param  array<HistoricoPromotor>  $novosHistoricoPromotores
     */
    private function createHistoricoEvento(Evento $evento, array $novosHistoricoPromotores, int $historicoId): void
    {
        HistoricoEvento::query()->create([
            'titulo'                          => $evento->titulo,
            'tipo'                            => $evento->tipo,
            'periodo_inicio'                  => $evento->periodo_inicio,
            'periodo_fim'                     => $evento->periodo_fim,
            'historico_promotor_titular_id'   => $novosHistoricoPromotores[$evento->promotor_titular_id]->id,
            'historico_promotor_designado_id' => $novosHistoricoPromotores[$evento->promotor_designado_id]->id,
            'historico_id'                    => $historicoId,
        ]);
    }
}
