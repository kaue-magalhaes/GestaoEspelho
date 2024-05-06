<?php

namespace App\Listeners\EspelhoUpdated;

use App\Events\EspelhoUpdatedEvent;
use App\Models\UrgenciaAtendimento;
use App\Utils\ChecksArray;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUrgenciaAtendimentosListener
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
     *
     * @throws Exception
     */
    public function handle(EspelhoUpdatedEvent $event): void
    {
        try {
            $atendimentosUrgenciaDados = $event->getAtendimentosUrgenciaDados();

            ChecksArray::is_array($atendimentosUrgenciaDados);

            $atendimentosUrgenciaIds = UrgenciaAtendimento::all()->pluck('id')->toArray();

            DB::beginTransaction();

            foreach ($atendimentosUrgenciaDados as $atendimentoUrgencia) {
                if (! $this->isUrgenciaAtendimentoValid($atendimentoUrgencia)) {
                    continue;
                }
                if (isset($atendimentoUrgencia['uuid'])) {
                    UrgenciaAtendimento::query()->create([
                        'periodo_inicio'        => $atendimentoUrgencia['periodo_inicio'],
                        'periodo_fim'           => $atendimentoUrgencia['periodo_fim'],
                        'promotor_designado_id' => $atendimentoUrgencia['promotor_designado_id'],
                    ]);
                }
                if (! isset($atendimentoUrgencia['uuid'])) {
                    $urgenciaAtendimento = UrgenciaAtendimento::query()->find($atendimentoUrgencia['id']);
                    $urgenciaAtendimento->update([
                        'periodo_inicio'        => $atendimentoUrgencia['periodo_inicio'],
                        'periodo_fim'           => $atendimentoUrgencia['periodo_fim'],
                        'promotor_designado_id' => $atendimentoUrgencia['promotor_designado_id'],
                    ]);
                    if (! isset($atendimentoUrgencia['id'])) {
                        continue;
                    }
                    $atendimentosUrgenciaIds = array_diff($atendimentosUrgenciaIds, [$atendimentoUrgencia['id']]);
                }
            }
            UrgenciaAtendimento::destroy($atendimentosUrgenciaIds);
            DB::commit();
            Log::info('Atendimentos de urgência atualizados com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar os atendimentos de urgência: ' . $e->getMessage());

            throw new Exception('Erro ao atualizar os atendimentos de urgência');
        }
    }

    /**
     * Check if the urgencia atendimento is valid
     *
     * @param  array{id:string|null, uuid: string|null, periodo_inicio: string|null, periodo_fim: string|null, promotor_designado_id: string|null}  $atendimentoUrgencia
     */
    private function isUrgenciaAtendimentoValid(array $atendimentoUrgencia): bool
    {
        return isset($atendimentoUrgencia['periodo_inicio'], $atendimentoUrgencia['periodo_fim'], $atendimentoUrgencia['promotor_designado_id']);
    }
}
