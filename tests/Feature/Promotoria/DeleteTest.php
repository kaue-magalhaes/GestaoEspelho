<?php

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\InternalSystemUser;
use App\Models\Municipio;
use App\Models\Promotor;
use App\Models\Promotoria;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\delete;

it('should be possible to delete a Promotoria', function () {
    Municipio::factory()->create();
    $user             = InternalSystemUser::factory()->create();
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();
    $promotoria       = Promotoria::factory()->create(
        [
            'nome'                => 'Promotoria Teste',
            'is_especializada'    => true,
            'espelho_id'          => $espelho->id,
            'promotor_titular_id' => $promotor_titular->id,
            'grupo_promotoria_id' => $grupo_promotoria->id,
        ]
    );
    $user->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status'  => 1,
    ]);

    actingAs($user);
    $request = delete(route('promotoria.destroy', $promotoria));

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria deletada com sucesso!');

    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to delete a Promotoria if it is not authorized', function () {
    Municipio::factory()->create();
    $unauthorizedUser = InternalSystemUser::factory()->create();
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();
    $promotoria       = Promotoria::factory()->create(
        [
            'nome'                => 'Promotoria Teste',
            'is_especializada'    => true,
            'espelho_id'          => $espelho->id,
            'promotor_titular_id' => $promotor_titular->id,
            'grupo_promotoria_id' => $grupo_promotoria->id,
        ]
    );
    $unauthorizedUser->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(1, 4),
        'status'  => 1,
    ]);

    actingAs($unauthorizedUser);
    $request = delete(route('promotoria.destroy', $promotoria));

    $request->assertStatus(403);

    // agora um usuário autorizado, ou seja, com nível maior ou igual a 5 no sistema SOL
    $authorizedUser = InternalSystemUser::factory()->create();
    $authorizedUser->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status'  => 1,
    ]);

    actingAs($authorizedUser);
    $request = delete(route('promotoria.destroy', $promotoria));

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria deletada com sucesso!');

    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to delete a Promotoria with associated Promotores', function () {
    // Crie uma Promotoria com Promotores associados
    // Tente deletar a Promotoria
    // Verifique se a resposta tem um status 400 ou 403
    // Verifique se a Promotoria ainda existe no banco de dados
})->todo();

it('should not be possible to delete a Promotoria with associated GruposPromotoria', function () {
    // Crie uma Promotoria com GruposPromotoria associados
    // Tente deletar a Promotoria
    // Verifique se a resposta tem um status 400 ou 403
    // Verifique se a Promotoria ainda existe no banco de dados
})->todo();

it('should not be possible to delete a Promotoria with associated Espelhos', function () {
    // Crie uma Promotoria com Espelhos associados
    // Tente deletar a Promotoria
    // Verifique se a resposta tem um status 400 ou 403
    // Verifique se a Promotoria ainda existe no banco de dados
})->todo();

it('should not be possible to delete a non-existent Promotoria', function () {
    // Tente deletar uma Promotoria que não existe
    // Verifique se a resposta tem um status 404
})->todo();

it('should not be possible for an unauthenticated user to delete a Promotoria', function () {
    // Tente deletar uma Promotoria sem estar autenticado
    // Verifique se a resposta tem um status 401 ou 403
})->todo();
