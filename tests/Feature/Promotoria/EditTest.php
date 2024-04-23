<?php

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\InternalSystemNivel;
use App\Models\InternalSystemUser;
use App\Models\Municipio;
use App\Models\Promotor;

use App\Models\Promotoria;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\put;

it('should be possible to edit a Promotoria', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria alterada com sucesso!');

    assertDatabaseHas('promotorias', [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);
});

it('should not be possible to edit a Promotoria if it is not authorized', function () {
    // primeiro um usuário não autorizado, ou seja, com nível menor que 5 no sistema SOL
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $unauthorizedUser->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(1, 4),
        'status'     => 1,
    ]);

    actingAs($unauthorizedUser);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertStatus(403);

    // agora um usuário autorizado, ou seja, com nível maior ou igual a 5 no sistema SOL
    $authorizedUser = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $authorizedUser->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($authorizedUser);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria alterada com sucesso!');

    assertDatabaseHas('promotorias', [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);
});

it('should not be possible to edit a Promotoria without a Promotor Titular', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('promotor_titular_id');
    $request->assertStatus(302);
});

it('should not be possible to edit a Promotoria without a Grupo Promotoria', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
    ]);

    $request->assertSessionHasErrors('grupo_promotoria_id');
    $request->assertStatus(302);
});

it('should not be possible to edit a Promotoria without a name ', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('nome');
    $request->assertStatus(302);
});

it('should not be possible to edit a Promotoria with a non-existent Promotor Titular', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => 999,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('promotor_titular_id');
    $request->assertStatus(302);
});

it('should not be possible to edit a Promotoria with a non-existent Grupo Promotoria', function () {
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
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $promotoria), [
        'nome'                => 'Novo Nome',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => 999,
    ]);

    $request->assertSessionHasErrors('grupo_promotoria_id');
    $request->assertStatus(302);
});

it('should not be possible to edit a Promotoria with a name that already exists', function () {
    Municipio::factory()->create();
    $user             = InternalSystemUser::factory()->create();
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();
    $firstPromotoria  = Promotoria::factory()->create(
        [
            'nome'                => 'Promotoria Teste',
            'is_especializada'    => true,
            'espelho_id'          => $espelho->id,
            'promotor_titular_id' => $promotor_titular->id,
            'grupo_promotoria_id' => $grupo_promotoria->id,
        ]
    );
    $secondPromotoria = Promotoria::factory()->create(
        [
            'is_especializada'    => true,
            'espelho_id'          => $espelho->id,
            'promotor_titular_id' => $promotor_titular->id,
            'grupo_promotoria_id' => $grupo_promotoria->id,
        ]
    );
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($user);
    $request = put(route('promotoria.update', $secondPromotoria), [
        'nome'                => 'Promotoria Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('nome');
    $request->assertStatus(302);
});


it('should be possible to edit a Promotoria with associated Promotores', function () {
    // Crie uma Promotoria com Promotores associados
    // Tente editar a Promotoria
    // Verifique se a resposta tem um status 200 ou 302
    // Verifique se a Promotoria foi editada corretamente no banco de dados
})->todo();

it('should be possible to edit a Promotoria with associated GruposPromotoria', function () {
    // Crie uma Promotoria com GruposPromotoria associados
    // Tente editar a Promotoria
    // Verifique se a resposta tem um status 200 ou 302
    // Verifique se a Promotoria foi editada corretamente no banco de dados
})->todo();

it('should be possible to edit a Promotoria with associated Espelhos', function () {
    // Crie uma Promotoria com Espelhos associados
    // Tente editar a Promotoria
    // Verifique se a resposta tem um status 200 ou 302
    // Verifique se a Promotoria foi editada corretamente no banco de dados
})->todo();

it('should not be possible to edit a non-existent Promotoria', function () {
    // Tente editar uma Promotoria que não existe
    // Verifique se a resposta tem um status 404
})->todo();

it('should not be possible for an unauthenticated user to edit a Promotoria', function () {
    // Tente editar uma Promotoria sem estar autenticado
    // Verifique se a resposta tem um status 401 ou 403
})->todo();
