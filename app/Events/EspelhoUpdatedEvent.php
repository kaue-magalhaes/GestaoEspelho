<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class EspelhoUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $id;

    public Request $request;

    /**
     * Create a new event instance.
     */
    public function __construct(Request $request, string $id)
    {
        $this->id      = $id;
        $this->request = $request;
    }

    /**
     * Get the id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * get the periodoEspelho from request
     *
     * @return array<string>
     */
    public function getPeriodoEspelho(): array
    {
        return $this->request->input('periodoEspelho');
    }

    /**
     * get the listaEventos from request
     *
     * @return array<array{uuid: string, titulo: string, tipo: string, periodo_inicio: string, periodo_fim: string, promotor_titular_id: string, promotor_designado_id: string}>
     */
    public function getListaEventos(): array
    {
        return $this->request->input('listaEventos');
    }

    /**
     * get the atendimentosUrgenciaDados from request
     *
     * @return array<array{uuid: string, periodo_inicio: string, periodo_fim: string, promotor_designado_id: string}>
     */
    public function getAtendimentosUrgenciaDados(): array
    {
        return $this->request->input('atendimentosUrgenciaDados');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
