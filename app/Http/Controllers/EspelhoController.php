<?php

namespace App\Http\Controllers;

use App\Models\Espelho;
use App\Models\Promotor;
use App\Models\Promotoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EspelhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $espelho    = Espelho::with('promotorias.promotor.eventos', 'promotorias.promotor.urgenciasAtendimento')->get()->toArray();
        $promotores = Promotor::all();
        $promotoria = Promotoria::with('promotor')->get()->toArray();

        //dd($espelho);

        return Inertia::render('Espelho', [
            'promotores' => $promotores,
            'promotoria' => $promotoria
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
