<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotoriaRequest;
use App\Models\Promotoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class PromotoriaController extends Controller
{
    public function index(): Collection
    {
        return Promotoria::query()
            ->get();
    }

    public function store(PromotoriaRequest $request): RedirectResponse
    {
        $this->authorize('create', Promotoria::class);

        Promotoria::query()
            ->create(
                $request->validated()
            );

        return to_route('admin.promotorias')->with('success', 'Promotoria criada com sucesso!');
    }

    public function destroy(Promotoria $promotoria): RedirectResponse
    {
        $this->authorize('delete', $promotoria);

        $promotoria->delete();

        return back()->with('success', 'Promotoria deletada com sucesso!');
    }
}
