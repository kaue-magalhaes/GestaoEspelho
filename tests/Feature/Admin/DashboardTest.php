<?php

use App\Models\InternalSystemUser;
use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('can access the admin dashboard', function () {
    // eu quero garantir seja possível acessar a rota 'admin.dashboard' recebendo um status 200
    $user = InternalSystemUser::factory()->create();
    $user->niveis()->create(['sistema' => 'Sol', 'nivel' => 5]);

    actingAs($user);
    $response = get(route('admin.dashboard'));

    $response->assertStatus(200);
});

it('can access the admin dashboard and see the Inertia view', function () {
    // eu quero garantir que a está sendo retornada a Inertia view 'Admin/Dashboard' ao acessar a rota 'admin.dashboard'
    $user = InternalSystemUser::factory()->create();
    $user->niveis()->create(['sistema' => 'Sol', 'nivel' => 5]);

    actingAs($user);
    $response = get(route('admin.dashboard'));

    $response->assertInertia(
        fn (AssertableInertia $page) => $page
            ->component('Admin/Dashboard')
    );
});

it('cannot access the admin dashboard if not authenticated', function () {
    // eu quero garantir somente seja possível acessar a rota 'admin.dashboard' se o usuário estiver autenticado
    $response = get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

it('cannot access the admin dashboard if not authorized', function () {
    // eu quero garantir que somente seja possível acessar a rota 'admin.dashboard' se o usuário tiver permissão, ou seja, se tiver niveis com o sistema 'Sol' com nivel maior ou igual a 5
    $unauthorizedUser = InternalSystemUser::factory()->create();
    $unauthorizedUser->niveis()->create(['sistema' => 'Sol', 'nivel' => 4]);

    actingAs($unauthorizedUser);
    $response = get(route('admin.dashboard'));

    $response->assertForbidden();

    $authorizedUser = InternalSystemUser::factory()->create();
    $authorizedUser->niveis()->create(['sistema' => 'Sol', 'nivel' => 5]);

    actingAs($authorizedUser);
    $response = get(route('admin.dashboard'));

    $response->assertStatus(200);
});
