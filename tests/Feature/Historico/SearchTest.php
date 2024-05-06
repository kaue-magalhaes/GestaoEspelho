<?php

use App\Models\Historico\HistoricoEspelho;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

it('should be able to search a historico by date', function () {
    $user = User::where('login_intranet', env('USER_TESTING_LOGIN'))
        ->first()
        ->toArray();
    $historicosErrados = HistoricoEspelho::factory()->count(5)->create([
        'created_at' => '2021-10-09 00:00:00',
    ]);
    $historico1 = HistoricoEspelho::factory()->create([
        'usuario_id' => $user['id'],
        'created_at' => '2021-10-10 00:00:00',
    ]);
    $historico2 = HistoricoEspelho::factory()->create([
        'usuario_id' => $user['id'],
        'created_at' => '2021-10-11 00:00:00',
    ]);

    Auth::loginUsingId($user['id']);

    $request = get(route('espelho.history', [
        'filters' => [
            'search' => '',
            'period' => [
                'start' => '2021-10-10',
                'end'   => '2021-10-11',
            ],
        ],
    ]));

    foreach ($historicosErrados as $historicoErrado) {
        $request->assertDontSee($historicoErrado->created_at->toJSON());
    }

    $request->assertSee($historico1->created_at->toJSON());
    $request->assertSee($historico2->created_at->toJSON());
});
