<?php

use App\Models\Promotor;

use function Pest\Laravel\getJson;

it('should be able to list promotores after the api request', function () {
    $promotor = Promotor::all();

    $request = getJson(route('api.promotores.list'))
        ->assertOk();

    $request->assertJsonFragment([
        'id'   => $promotor[0]->id,
        'nome' => $promotor[0]->nome,
    ]);
});
