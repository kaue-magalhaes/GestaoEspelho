<?php

use App\Models\Promotor;

use function Pest\Laravel\getJson;

it('should be able to list promotores after the api request', function () {
    $promotor = Promotor::factory()->create();

    $request = getJson(route('api.promotores.list'))
        ->assertOk();

    $request->assertJsonFragment([
        'id'            => $promotor->id,
        'nome'          => $promotor->nome,
        'is_substituto' => $promotor->is_substituto,
        'created_at'    => $promotor->created_at->format('Y-m-d h:i:s'),
        'updated_at'    => $promotor->updated_at->format('Y-m-d h:i:s'),
    ]);
});
