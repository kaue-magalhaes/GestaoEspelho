<?php

namespace App\Listeners;

use App\Events\EspelhoUpdatedEvent;
use App\Models\UrgenciaAtendimento;
use App\Utils\ChecksArray;
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
     */
    public function handle(EspelhoUpdatedEvent $event): void
    {
        try {
            $atendimentosUrgenciaDados = $event->getAtendimentosUrgenciaDados();

            ChecksArray::is_array($atendimentosUrgenciaDados);

            DB::beginTransaction();
            foreach ($atendimentosUrgenciaDados as $atendimentoUrgencia) {
                if (!$this->isUrgenciaAtendimentoValid($atendimentoUrgencia)) {
                    continue;
                }
                $urgenciaAtendimento = UrgenciaAtendimento::find($atendimentoUrgencia['uuid']);
                if ($urgenciaAtendimento) {
                    $urgenciaAtendimento->update([
                        'periodo_inicio'        => $atendimentoUrgencia['periodo_inicio'],
                        'periodo_fim'           => $atendimentoUrgencia['periodo_fim'],
                        'promotor_designado_id' => $atendimentoUrgencia['promotor_designado_id']
                    ]);
                } 
                if (!$urgenciaAtendimento){
                    UrgenciaAtendimento::create([
                        'periodo_inicio'        => $atendimentoUrgencia['periodo_inicio'],
                        'periodo_fim'           => $atendimentoUrgencia['periodo_fim'],
                        'promotor_designado_id' => $atendimentoUrgencia['promotor_designado_id']
                    ]);
                }
            }
            DB::commit();
            Log::info('Atendimentos de urgência atualizados com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar os atendimentos de urgência: ' . $e->getMessage());
            throw new \Exception('Erro ao atualizar os atendimentos de urgência');
        }
    }

    private function isUrgenciaAtendimentoValid(array $atendimentoUrgencia): bool
    {
        return isset($atendimentoUrgencia['periodo_inicio'], $atendimentoUrgencia['periodo_fim'], $atendimentoUrgencia['promotor_designado_id']);
    }
}
