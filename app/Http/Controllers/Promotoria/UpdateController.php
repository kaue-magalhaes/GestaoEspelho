<?php

namespace App\Http\Controllers\Promotoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promotoria\UpdateRequest;
use App\Models\Promotoria;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateRequest $request, Promotoria $promotoria): RedirectResponse
    {
        $this->authorize('update', $promotoria);

        $promotoria->update(
            $request->validated()
        );

        return back()->with('success', 'Promotoria alterada com sucesso!');
    }
}
