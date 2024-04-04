<?php

namespace App\Events;

use App\Models\Espelho;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicarEspelhoEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Busca o periodo_inicio e periodo_fim do espelho
     *
     * @return array<string, string>
     */
    public function getPeriodoEspelho(): array
    {
        return [
            'periodo_inicio' => Espelho::first()->periodo_inicio,
            'periodo_fim'    => Espelho::first()->periodo_fim,
        ];
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
