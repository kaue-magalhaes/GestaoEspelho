<?php

namespace App\Http\Resources;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Evento
 */
class EventoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'titulo'                => $this->titulo,
            'tipo'                  => $this->tipo,
            'periodo_inicio'        => $this->periodo_inicio,
            'periodo_fim'           => $this->periodo_fim,
            'promotor_titular_id'   => $this->promotor_titular_id,
            'promotor_designado_id' => $this->promotor_designado_id,
        ];
    }
}
