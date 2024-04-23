<?php

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\InternalSystemUser;
use App\Models\Municipio;
use App\Models\Promotor;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

it('should be possible to create a Promotoria', function () {
    Municipio::factory()->create();
    $user             = InternalSystemUser::factory()->create();
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria criada com sucesso!');

    $this->assertDatabaseHas('promotorias', [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);
});

it('should not be possible to create a Promotoria if it is not authorized', function () {

})->todo();

it('should not be possible to create a Promotoria without a Promotor Titular', function () {

})->todo();

it('should not be possible to create a Promotoria without a Grupo Promotoria', function () {

})->todo();

it('should not be possible to create a Promotoria without a name ', function () {

})->todo();
