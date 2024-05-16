<?php

namespace App\Http\Controllers\Promotor;

use App\Http\Controllers\Controller;
use App\Models\Promotor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'nome'          => 'required|string',
            'is_substituto' => 'required|boolean',
        ]);

        Promotor::query()->create([
            'nome'          => $request->nome,
            'is_substituto' => $request->is_substituto,
        ]);

        return to_route('admin.dashboard')->with('success', 'Promotor criado com sucesso!');
    }
}
