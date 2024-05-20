<?php

namespace App\Http\Resources;

use App\Models\Promotoria;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Promotoria
 */
class PromotoriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'nome'                => $this->nome,
            'is_especializada'    => $this->is_especializada,
            'espelho_id'          => $this->espelho_id,
            'promotor_titular_id' => $this->promotor_titular_id,
            'grupo_promotoria_id' => $this->grupo_promotoria_id,
        ];
    }
}
