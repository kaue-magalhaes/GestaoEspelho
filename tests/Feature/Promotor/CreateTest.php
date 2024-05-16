<?php

use App\Models\InternalSystemUser;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to create a Promotor', function () {
    $user = InternalSystemUser::factory()->create();
    $user->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status ' => 1,
    ]);

    actingAs($user);
    $request = post(route('promotor.store'), [
        'nome'          => 'Promotor Name',
        'is_substituto' => false,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotor criado com sucesso!');

    assertDatabaseHas('promotores', [
        'nome'          => 'Promotor Name',
        'is_substituto' => false,
    ]);
});

it('should only be able to create a Promotor if is authorized', function () {
    $userAuthorized = InternalSystemUser::factory()->create();
    $userAuthorized->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status ' => 1,
    ]);

    $userUnauthorized = InternalSystemUser::factory()->create();
    $userUnauthorized->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(1, 4),
        'status ' => 1,
    ]);

    actingAs($userUnauthorized);
    $request = post(route('promotor.store'), [
        'nome'          => 'Promotor Name',
        'is_substituto' => false,
    ]);

    $request->assertForbidden();
    assertDatabaseCount('promotores', 0);

    actingAs($userAuthorized);
    $request = post(route('promotor.store'), [
        'nome'          => 'Promotor Name',
        'is_substituto' => false,
    ]);

    $request->assertRedirect();
    $request->assertSessionHas('success', 'Promotor criado com sucesso!');
    assertDatabaseHas('promotores', [
        'nome'          => 'Promotor Name',
        'is_substituto' => false,
    ]);
});

it('should not be possible to create a Promotor without a name', function () {
    $user = InternalSystemUser::factory()->create();
    $user->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status ' => 1,
    ]);

    actingAs($user);
    $request = post(route('promotor.store'), [
        'is_substituto' => false,
    ]);

    $request->assertSessionHasErrors('nome');
    assertDatabaseCount('promotores', 0);
});

it('should not be possible to create a Promotor without a in_substituto value', function () {
    $user = InternalSystemUser::factory()->create();
    $user->niveis()->create([
        'sistema' => 'Sol',
        'nivel'   => fake()->numberBetween(5, 10),
        'status ' => 1,
    ]);

    actingAs($user);
    $request = post(route('promotor.store'), [
        'nome' => 'Promotor Name',
    ]);

    $request->assertSessionHasErrors('is_substituto');
    assertDatabaseCount('promotores', 0);
});
