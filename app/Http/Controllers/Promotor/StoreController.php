<?php

namespace App\Http\Controllers\Promotor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promotor\StoreRequest;
use App\Models\Promotor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $this->authorize('isAdmin', $user);

        Promotor::query()->create([
            'nome'          => $request->nome,
            'is_substituto' => $request->is_substituto,
        ]);

        return to_route('admin.dashboard')->with('success', 'Promotor criado com sucesso!');
    }
}
