<?php

namespace App\Http\Controllers;

use App\Events\EspelhoUpdatedEvent;
use App\Events\PublicarEspelhoEvent;
use App\Models\Espelho;
use App\Models\Evento;
use App\Models\GrupoPromotoria;
use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\Historico\HistoricoEvento;
use App\Models\Historico\HistoricoGrupoPromotoria;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Historico\HistoricoPromotoria;
use App\Models\Historico\HistoricoUrgenciaAtendimento;
use App\Models\Promotor;
use App\Models\Promotoria;
use App\Models\UrgenciaAtendimento;
use Illuminate\Database\Eloquent\Builder;
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
        //dd($grupoPromotoriasArray);
        //dd($espelho, $promotores, $eventos, $urgenciaAtendimentos);

        return Inertia::render('Espelho/Editor', [
            'espelho' => Espelho::query()
                ->with('promotorias')
                ->first()
                ->toArray(),
            'promotores' => Promotor::query()
                ->get()
                ->toArray(),
            'grupoPromotorias' => GrupoPromotoria::query()
                ->with(['promotorias', 'promotorias.promotor', 'municipio', 'promotorias.promotor.eventos'])
                ->get()
                ->toArray(),
            'promotorias' => Promotoria::query()
                ->with(['promotor', 'grupoPromotoria', 'grupoPromotoria.municipio', 'promotor.eventos'])
                ->get()
                ->toArray(),
            'eventos' => Evento::query()
                ->get()
                ->toArray(),
            'urgenciaAtendimentos' => UrgenciaAtendimento::query()
                ->get()
                ->toArray(),
        ]);
    }

    public function index(): Response
    {
        $historicoId = Historico::query()->orderBy('id', 'desc')->first();

        return Inertia::render('Espelho/Index', [
            'espelho' => HistoricoEspelho::query()
                ->where('historico_id', $historicoId->id)
                ->with('promotorias')
                ->first()
                ->toArray(),
            'promotores' => HistoricoPromotor::query()
                ->get()
                ->toArray(),
            'grupoPromotorias' => HistoricoGrupoPromotoria::query()
                ->with(['promotorias', 'promotorias.promotor', 'municipio', 'promotorias.promotor.eventos'])
                ->get()
                ->toArray(),
            'promotorias' => HistoricoPromotoria::query()
                ->with(['promotor', 'grupoPromotoria', 'grupoPromotoria.municipio', 'promotor.eventos'])
                ->get()
                ->toArray(),
            'eventos' => HistoricoEvento::query()
                ->get()
                ->toArray(),
            'urgenciaAtendimentos' => HistoricoUrgenciaAtendimento::query()
                ->get()
                ->toArray(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return Inertia::render('Espelho/Show', [
            'espelho' => HistoricoEspelho::query()
                ->where('historico_id', $id)
                ->with('promotorias')
                ->first()
                ->toArray(),
            'promotores' => HistoricoPromotor::query()
                ->where('historico_id', $id)
                ->get()
                ->toArray(),
            'grupoPromotorias' => HistoricoGrupoPromotoria::query()
                ->where('historico_id', $id)
                ->with(['promotorias', 'promotorias.promotor', 'municipio', 'promotorias.promotor.eventos'])
                ->first()
                ->toArray(),
            'promotorias' => HistoricoPromotoria::query()
                ->where('historico_id', $id)
                ->with(['promotor', 'grupoPromotoria', 'grupoPromotoria.municipio', 'promotor.eventos'])
                ->first()
                ->toArray(),
            'eventos' => HistoricoEvento::query()
                ->where('historico_id', $id)
                ->first()
                ->toArray(),
            'urgenciaAtendimentos' => HistoricoUrgenciaAtendimento::query()
                ->where('historico_id', $id)
                ->first()
                ->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //dd($request->all());
        EspelhoUpdatedEvent::dispatch($request, $id);
    }

    /**
     * Publish the specified resource in storage.
     */
    public function publish(): void
    {
        PublicarEspelhoEvent::dispatch();
    }

    /**
     * Shows the history list
     */
    public function history(): Response
    {
        //dd(\request()->all());
        return Inertia::render('HistoryList', [
            'espelhos' => HistoricoEspelho::query()
                ->when(
                    request()->has('filters') && isset(request('filters')['search']) && request('filters')['search'] !== null,
                    function (Builder $query) {
                        $query->where('titulo', 'like', '%' . request('filters')['search'] . '%');
                    }
                )
                ->when(
                    request()->has('filters') && isset(request('filters')['period']) && request('filters')['period']['start'] !== null && request('filters')['period']['end'] !== null,
                    function (Builder $query) {
                        $endDate = date('Y-m-d H:i:s', strtotime(request('filters')['period']['end'] . ' 23:59:59'));
                        $query->whereBetween('created_at', [request('filters')['period']['start'], $endDate]);
                    }
                )
                ->orderBy('created_at', request()->has('orderBy') ? request('orderBy') : 'desc')
                ->with('user')
                ->paginate(5)
                ->toArray(),
            'filters' => \request('filters', [
                'search' => request('search', ''),
                'period' => [
                    'start' => request('start'),
                    'end'   => request('end'),
                ],
            ]),
            'orderAsc' => request()->has('orderBy') && request('orderBy') === 'asc',
        ]);
    }
}
