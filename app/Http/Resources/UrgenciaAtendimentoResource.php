<?php

namespace App\Http\Resources;

use App\Models\UrgenciaAtendimento;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UrgenciaAtendimento
 */
class UrgenciaAtendimentoResource extends JsonResource
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
            'periodo_inicio'        => $this->periodo_inicio,
            'periodo_fim'           => $this->periodo_fim,
            'promotor_designado_id' => $this->promotor_designado_id,
        ];
    }
}
