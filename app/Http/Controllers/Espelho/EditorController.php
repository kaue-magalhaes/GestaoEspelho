<?php

namespace App\Http\Controllers\Espelho;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotorResource;
use App\Models\Espelho;
use App\Models\Evento;
use App\Models\GrupoPromotoria;
use App\Models\Promotor;
use App\Models\Promotoria;
use App\Models\UrgenciaAtendimento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EditorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $promotores = Promotor::query()->get();

        return Inertia::render('Espelho/Editor', [
            'espelho' => Espelho::query()
                ->with('promotorias')
                ->first()
                ->toArray(),
            'promotores'       => PromotorResource::collection($promotores),
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
}
