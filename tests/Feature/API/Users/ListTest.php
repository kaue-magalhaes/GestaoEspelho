<?php

use App\Models\User;

use function Pest\Laravel\getJson;

it('should be able to list users after the api request', function () {
    $users   = User::all();
    $request = getJson(route('api.users.list'))
        ->assertOk();

    $request->assertJsonFragment(
        [
            'id'   => $users[0]->id,
            'nome' => $users[0]->nome,
        ]
    );
})->todo();
