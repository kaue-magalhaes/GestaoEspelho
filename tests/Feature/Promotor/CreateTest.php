<?php

use App\Models\InternalSystemUser;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to create a Promotor', function () {
    $user = InternalSystemUser::factory()->create();

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
