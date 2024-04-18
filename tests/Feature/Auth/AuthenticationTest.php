<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::where('login_intranet', env('USER_TESTING_LOGIN'))
        ->first()
        ->toArray();

    $response = $this->post(route('login'), [
        'login_intranet' => $user['login_intranet'],
        'senha_intranet' => env('USER_TESTING_PASSWORD'),
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function () {
    $user = User::where('login_intranet', env('USER_TESTING_LOGIN'))
        ->first()
        ->toArray();

    $this->post(route('login'), [
        'login_intranet' => $user['login_intranet'],
        'senha_intranet' => 'wrong-password',
    ]);

    $this->assertGuest();
});
