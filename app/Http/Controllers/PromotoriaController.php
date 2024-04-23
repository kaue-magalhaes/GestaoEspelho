<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotoriaRequest;
use App\Models\Promotoria;
use Illuminate\Http\RedirectResponse;

class PromotoriaController extends Controller
{
    public function store(PromotoriaRequest $request): RedirectResponse
    {
        $this->authorize('create', Promotoria::class);

        Promotoria::query()
            ->create(
                $request->validated()
            );

        return back()->with('success', 'Promotoria criada com sucesso!');
    }
}
