<?php

namespace App\Http\Controllers;

use App\Events\EspelhoUpdatedEvent;
use App\Events\PublicarEspelhoEvent;
use App\Models\Historico\Historico;
use App\Models\Historico\HistoricoEspelho;
use App\Models\Historico\HistoricoEvento;
use App\Models\Historico\HistoricoGrupoPromotoria;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Historico\HistoricoPromotoria;
use App\Models\Historico\HistoricoUrgenciaAtendimento;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EspelhoController extends Controller
{
    public function index(): Response
    {
        $historicoId = Historico::query()->orderBy('id', 'desc')->first();

        return Inertia::render('Espelho/Index', [
            'historicoEspelho' => HistoricoEspelho::query()
                ->where('historico_id', $historicoId->id)
                ->with('promotorias')
                ->first()
                ->toArray(),
            'historicoPromotores' => HistoricoPromotor::query()
                ->where('historico_id', $historicoId->id)
                ->get()
                ->toArray(),
            'historicoGrupoPromotorias' => HistoricoGrupoPromotoria::query()
                ->where('historico_id', $historicoId->id)
                ->with(['promotorias', 'promotorias.promotor', 'municipio', 'promotorias.promotor.eventos'])
                ->get()
                ->toArray(),
            'historicoPromotorias' => HistoricoPromotoria::query()
                ->where('historico_id', $historicoId->id)
                ->with(['promotor', 'grupoPromotoria', 'grupoPromotoria.municipio', 'promotor.eventos'])
                ->get()
                ->toArray(),
            'historicoEventos' => HistoricoEvento::query()
                ->where('historico_id', $historicoId->id)
                ->get()
                ->toArray(),
            'historicoUrgenciaAtendimentos' => HistoricoUrgenciaAtendimento::query()
                ->where('historico_id', $historicoId->id)
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
            'historicoEspelho' => HistoricoEspelho::query()
                ->where('historico_id', $id)
                ->with('promotorias')
                ->first()
                ->toArray(),
            'historicoPromotores' => HistoricoPromotor::query()
                ->where('historico_id', $id)
                ->get()
                ->toArray(),
            'historicoGrupoPromotorias' => HistoricoGrupoPromotoria::query()
                ->where('historico_id', $id)
                ->with(['promotorias', 'promotorias.promotor', 'municipio', 'promotorias.promotor.eventos'])
                ->get()
                ->toArray(),
            'historicoPromotorias' => HistoricoPromotoria::query()
                ->where('historico_id', $id)
                ->with(['promotor', 'grupoPromotoria', 'grupoPromotoria.municipio', 'promotor.eventos'])
                ->get()
                ->toArray(),
            'historicoEventos' => HistoricoEvento::query()
                ->where('historico_id', $id)
                ->get()
                ->toArray(),
            'historicoUrgenciaAtendimentos' => HistoricoUrgenciaAtendimento::query()
                ->where('historico_id', $id)
                ->get()
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
