<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromotoriaRequest;
use App\Models\Promotoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromotoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotoriaRequest $request): RedirectResponse
    {
        Promotoria::query()
            ->create(
                $request->validated()
            );

        return back()->with('success', 'Promotoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotoria $promotoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotoria $promotoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotoria $promotoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotoria $promotoria)
    {
        //
    }
}
