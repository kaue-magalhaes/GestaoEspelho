<?php

use App\Models\Historico\HistoricoEspelho;
use App\Models\User;

use function Pest\Laravel\get;

it('should be able to search a historico by date', function () {
    $user              = User::factory()->create();
    $historicosErrados = HistoricoEspelho::factory()->count(5)->create([
        'created_at' => '2021-10-09 00:00:00',
    ]);
    $historico1 = HistoricoEspelho::factory()->create([
        'usuario_id' => $user->id,
        'created_at' => '2021-10-10 00:00:00',
    ]);
    $historico2 = HistoricoEspelho::factory()->create([
        'usuario_id' => $user->id,
        'created_at' => '2021-10-11 00:00:00',
    ]);

    $this->actingAs($user);

    $request = get(route('espelho.history', [
        'initial_date' => '2021-10-10',
        'final_date'   => '2021-10-12',
    ]));

    foreach ($historicosErrados as $historicoErrado) {
        $request->assertDontSee($historicoErrado->created_at->toJSON());
    }

    $request->assertSee($historico1->created_at->toJSON());
    $request->assertSee($historico2->created_at->toJSON());
});
