<?php

namespace App\Listeners\EspelhoUpdated;

use App\Events\EspelhoUpdatedEvent;
use App\Models\Evento;
use App\Utils\ChecksArray;
use Exception;
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
     *
     * @throws Exception
     */
    public function handle(EspelhoUpdatedEvent $event): void
    {
        try {
            $listaEventos = $event->getListaEventos();
            ChecksArray::is_array($listaEventos);
            $listaEventosIds = Evento::all()->pluck('id')->toArray();

            DB::beginTransaction();
            foreach ($listaEventos as $evento) {
                if (! $this->eventoIsValid($evento)) {
                    throw new Exception('Evento inválido');
                }
                if (! isset($evento['uuid'])) {
                    $eventoDatabase = Evento::query()->find($evento['id']);
                    $eventoDatabase->update([
                        'titulo'                => $evento['titulo'],
                        'tipo'                  => $evento['tipo'],
                        'periodo_inicio'        => $evento['periodo_inicio'],
                        'periodo_fim'           => $evento['periodo_fim'],
                        'promotor_titular_id'   => $evento['promotor_titular_id'],
                        'promotor_designado_id' => $evento['promotor_designado_id'],
                    ]);
                    $listaEventosIds = array_diff($listaEventosIds, [$evento['id']]);
                }
                if (isset($evento['uuid'])) {
                    Evento::query()->create([
                        'titulo'                => $evento['titulo'],
                        'tipo'                  => $evento['tipo'],
                        'periodo_inicio'        => $evento['periodo_inicio'],
                        'periodo_fim'           => $evento['periodo_fim'],
                        'promotor_titular_id'   => $evento['promotor_titular_id'],
                        'promotor_designado_id' => $evento['promotor_designado_id'],
                    ]);
                }
            }
            Evento::destroy($listaEventosIds);
            DB::commit();
            Log::info('Lista de eventos atualizada com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar a lista de eventos: ' . $e->getMessage());

            throw new Exception('Erro ao atualizar a lista de eventos');
        }
    }

    /**
     * Check if the event is valid
     *
     * @param  array{uuid: string, titulo: string, tipo: string|null, periodo_inicio: string|null, periodo_fim: string|null, promotor_titular_id: string|null, promotor_designado_id: string|null}  $evento
     */
    private function eventoIsValid(array $evento): bool
    {
        return isset($evento['tipo']) && isset($evento['periodo_inicio']) && isset($evento['periodo_fim']) && isset($evento['promotor_titular_id']) && isset($evento['promotor_designado_id']);
    }
}
