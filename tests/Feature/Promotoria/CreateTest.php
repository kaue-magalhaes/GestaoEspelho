<?php

use App\Models\Espelho;
use App\Models\GrupoPromotoria;
use App\Models\InternalSystemNivel;
use App\Models\InternalSystemUser;
use App\Models\Municipio;
use App\Models\Promotor;

use App\Models\Promotoria;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be possible to create a Promotoria', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
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

    assertDatabaseHas('promotorias', [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);
});

it('should not be possible to create a Promotoria if it is not authorized', function () {
    // primeiro um usuário não autorizado, ou seja, com nível menor que 5 no sistema SOL
    Municipio::factory()->create();
    $unauthorizedUser = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $unauthorizedUser->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(1, 4),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();

    actingAs($unauthorizedUser);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertStatus(403);
    assertDatabaseCount('promotorias', 0);

    // agora um usuário autorizado, ou seja, com nível maior ou igual a 5 no sistema SOL
    $authorizedUser = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $authorizedUser->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);

    actingAs($authorizedUser);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotoria criada com sucesso!');

    assertDatabaseHas('promotorias', [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);
});

it('should not be possible to create a Promotoria without a Promotor Titular', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('promotor_titular_id');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to create a Promotoria without a Grupo Promotoria', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
    ]);

    $request->assertSessionHasErrors('grupo_promotoria_id');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to create a Promotoria without a name ', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('nome');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to create a Promotoria with a non-existent Promotor Titular', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => 999,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('promotor_titular_id');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to create a Promotoria with a non-existent Grupo Promotoria', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => 'Teste',
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => 999,
    ]);

    $request->assertSessionHasErrors('grupo_promotoria_id');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 0);
});

it('should not be possible to create a Promotoria with a name that already exists', function () {
    Municipio::factory()->create();
    $user = InternalSystemUser::factory()->create();
    InternalSystemNivel::factory()->create([
        'usuario_id' => $user->id,
        'sistema'    => 'SOL',
        'nivel'      => fake()->numberBetween(5, 10),
        'status'     => 1,
    ]);
    $espelho          = Espelho::factory()->create();
    $promotor_titular = Promotor::factory()->create();
    $grupo_promotoria = GrupoPromotoria::factory()->create();
    $promotoria       = Promotoria::factory()->create();

    actingAs($user);
    $request = post(route('promotoria.store'), [
        'nome'                => $promotoria->nome,
        'is_especializada'    => true,
        'espelho_id'          => $espelho->id,
        'promotor_titular_id' => $promotor_titular->id,
        'grupo_promotoria_id' => $grupo_promotoria->id,
    ]);

    $request->assertSessionHasErrors('nome');
    $request->assertStatus(302);
    assertDatabaseCount('promotorias', 1);
});
