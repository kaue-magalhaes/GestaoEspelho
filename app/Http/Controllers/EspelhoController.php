<?php

namespace App\Http\Controllers;

use App\Events\EspelhoUpdatedEvent;
use App\Events\PublicarEspelhoEvent;
use App\Models\Espelho;
use App\Models\Evento;
use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\Historico\HistoricoEvento;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Historico\HistoricoPromotoria;
use App\Models\Historico\HistoricoUrgenciaAtendimento;
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
    public function editor(): Response
    {
        $espelho              = Espelho::with('promotorias')->first()->toArray();
        $promotores           = Promotor::all()->toArray();
        $eventos              = Evento::all()->toArray();
        $urgenciaAtendimentos = UrgenciaAtendimento::all()->toArray();

        //dd($espelho, $promotores, $eventos, $urgenciaAtendimentos);

        return Inertia::render('EspelhoEditor', [
            'espelho'              => $espelho,
            'promotores'           => $promotores,
            'promotorias'          => $espelho['promotorias'],
            'eventos'              => $eventos,
            'urgenciaAtendimentos' => $urgenciaAtendimentos
        ]);
    }

    public function index(): Response
    {
        $historicoId                   = Historico::orderBy('id', 'desc')->first();
        $historicoEspelho              = HistoricoEspelho::where('historico_id', $historicoId->id)->first();
        $historicoPromotores           = HistoricoPromotor::where('historico_id', $historicoId->id)->get();
        $historicoPromotorias          = HistoricoPromotoria::where('historico_id', $historicoId->id)->get();
        $historicoEventos              = HistoricoEvento::where('historico_id', $historicoId->id)->get();
        $historicoUrgenciaAtendimentos = HistoricoUrgenciaAtendimento::where('historico_id', $historicoId->id)->get();

        //dd($espelho, $promotores, $eventos, $urgenciaAtendimentos);

        return Inertia::render('EspelhoIndex', [
            'espelho'              => $historicoEspelho,
            'promotores'           => $historicoPromotores,
            'promotorias'          => $historicoPromotorias['promotorias'],
            'eventos'              => $historicoEventos,
            'urgenciaAtendimentos' => $historicoUrgenciaAtendimentos
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
        //dd($request->listaEventos, $request->atendimentosUrgenciaDados);
        EspelhoUpdatedEvent::dispatch($request, $id);
    }

    /**
     * Publish the specified resource in storage.
     */
    public function publish(Request $request, string $id)
    {
        PublicarEspelhoEvent::dispatch($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
