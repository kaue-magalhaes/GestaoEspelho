<?php

namespace App\Http\Controllers;

use App\Events\EspelhoUpdatedEvent;
use App\Models\Espelho;
use App\Models\Evento;
use App\Models\Promotor;
use App\Models\UrgenciaAtendimento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EspelhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $espelho              = Espelho::with('promotorias')->first()->toArray();
        $promotores           = Promotor::all()->toArray();
        $eventos              = Evento::all()->toArray();
        $urgenciaAtendimentos = UrgenciaAtendimento::all()->toArray();

        //dd($espelho, $promotores, $eventos, $urgenciaAtendimentos);

        return Inertia::render('Espelho', [
            'espelho'              => $espelho,
            'promotores'           => $promotores,
            'promotoria'           => $espelho['promotorias'],
            'eventos'              => $eventos,
            'urgenciaAtendimentos' => $urgenciaAtendimentos
        ]);
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
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        EspelhoUpdatedEvent::dispatch($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
