<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotoriaRequest;
use App\Models\Promotoria;
use Illuminate\Http\RedirectResponse;

class PromotoriaController extends Controller
{
    public function index(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Promotoria::query()
            ->paginate(10);
    }

    public function store(PromotoriaRequest $request): RedirectResponse
    {
        $this->authorize('create', Promotoria::class);

        Promotoria::query()
            ->create(
                $request->validated()
            );

        return back()->with('success', 'Promotoria criada com sucesso!');
    }

    public function update(PromotoriaRequest $request, Promotoria $promotoria): RedirectResponse
    {
        $this->authorize('update', $promotoria);

        $promotoria->update(
            $request->validated()
        );

        return back()->with('success', 'Promotoria alterada com sucesso!');
    }

    public function destroy(Promotoria $promotoria): RedirectResponse
    {
        $this->authorize('delete', $promotoria);

        $promotoria->delete();

        return back()->with('success', 'Promotoria deletada com sucesso!');
    }
}
