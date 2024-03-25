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

        //dd($grupoPromotoriasArray);
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
        $historicoEspelho              = HistoricoEspelho::where('historico_id', $historicoId->id)->first()->toArray();
        $historicoPromotores           = HistoricoPromotor::where('historico_id', $historicoId->id)->get()->toArray();
        $historicoPromotorias          = HistoricoPromotoria::where('historico_id', $historicoId->id)->get()->toArray();
        $historicoEventos              = HistoricoEvento::where('historico_id', $historicoId->id)->get()->toArray();
        $historicoUrgenciaAtendimentos = HistoricoUrgenciaAtendimento::where('historico_id', $historicoId->id)->get()->toArray();

        //dd($historicoEspelho, $historicoPromotores, $historicoPromotorias, $historicoEventos, $historicoUrgenciaAtendimentos);

        return Inertia::render('EspelhoIndex', [
            'espelho'              => $historicoEspelho,
            'promotores'           => $historicoPromotores,
            'promotorias'          => $historicoPromotorias,
            'eventos'              => $historicoEventos,
            'urgenciaAtendimentos' => $historicoUrgenciaAtendimentos
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //dd($request->listaEventos, $request->atendimentosUrgenciaDados);
        EspelhoUpdatedEvent::dispatch($request, $id);
    }

    /**
     * Publish the specified resource in storage.
     */
    public function publish(Request $request, string $id): void
    {
        PublicarEspelhoEvent::dispatch();
    }
}
