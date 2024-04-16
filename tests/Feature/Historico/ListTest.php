<?php

use App\Models\Historico\HistoricoEspelho;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to view the Historicos list', function () {
    $user       = User::factory()->create();
    $historicos = HistoricoEspelho::factory()->count(5)->create([
        'usuario_id' => $user->id,
    ]);
    actingAs($user);

    $request = get(route('espelho.history'));

    foreach ($historicos as $historico) {
        $request->assertSee($historico->created_at->toJSON());
    }
});
