<?php

namespace App\Listeners\EspelhoUpdated;

use App\Events\EspelhoUpdatedEvent;
use App\Models\Evento;
use App\Utils\ChecksArray;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateListaEventosListener
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
            $listaEventos = $event->getListaEventos();

            ChecksArray::is_array($listaEventos);

            $listaEventosIds = Evento::all()->pluck('id')->toArray();

            DB::beginTransaction();
            foreach ($listaEventos as $evento) {
                if (!$this->isEventoValid($evento)) {
                    continue;
                }
                if (in_array($evento['uuid'], $listaEventosIds)) {
                    $eventoDatabase = Evento::find($evento['uuid']);
                    $eventoDatabase->update([
                        'titulo'                => $evento['titulo'],
                        'tipo'                  => $evento['tipo'],
                        'periodo_inicio'        => $evento['periodo_inicio'],
                        'periodo_fim'           => $evento['periodo_fim'],
                        'promotor_titular_id'   => $evento['promotor_titular_id'],
                        'promotor_designado_id' => $evento['promotor_designado_id']
                    ]);
                    $listaEventosIds = array_diff($listaEventosIds, [$evento['uuid']]);
                } else {
                    Evento::create([
                        'titulo'                => $evento['titulo'],
                        'tipo'                  => $evento['tipo'],
                        'periodo_inicio'        => $evento['periodo_inicio'],
                        'periodo_fim'           => $evento['periodo_fim'],
                        'promotor_titular_id'   => $evento['promotor_titular_id'],
                        'promotor_designado_id' => $evento['promotor_designado_id']
                    ]);
                }
            }
            Evento::destroy($listaEventosIds);
            DB::commit();
            Log::info('Lista de eventos atualizada com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar a lista de eventos: ' . $e->getMessage());

            throw new \Exception('Erro ao atualizar a lista de eventos');
        }
    }

    private function isEventoValid(array $evento): bool
    {
        return isset($evento['tipo']) && isset($evento['periodo_inicio']) && isset($evento['periodo_fim']) && isset($evento['promotor_titular_id']) && isset($evento['promotor_designado_id']);
    }
}
