<?php

use App\Models\Historico\HistoricoEspelho;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

it('should be able to view the Historicos list', function () {
    $user = User::where('login_intranet', env('USER_TESTING_LOGIN'))
        ->first()
        ->toArray();

    $historicos = HistoricoEspelho::factory()->count(5)->create([
        'usuario_id' => $user['id'],
    ]);

    Auth::loginUsingId($user['id']);

    $request = get(route('espelho.history'));

    foreach ($historicos as $historico) {
        $request->assertSee($historico->created_at->toJSON());
    }
});
