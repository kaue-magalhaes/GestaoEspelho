<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read int $id
 * @property-read string $nome
 * @property-read bool $is_substituto
 * @property-read \Illuminate\Support\Carbon $created_at
 * @property-read \Illuminate\Support\Carbon $updated_at
 */
class PromotorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nome'          => $this->nome,
            'is_substituto' => $this->is_substituto,
            'created_at'    => $this->created_at->format('Y-m-d h:i:s'),
            'updated_at'    => $this->updated_at->format('Y-m-d h:i:s'),
        ];
    }
}
