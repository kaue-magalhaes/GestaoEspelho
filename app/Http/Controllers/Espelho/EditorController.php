<?php

namespace App\Http\Controllers\Espelho;

use App\Http\Controllers\Controller;
use App\Http\Resources\EspelhoResource;
use App\Http\Resources\EventoResource;
use App\Http\Resources\GrupoPromotoriaResource;
use App\Http\Resources\PromotoriaResource;
use App\Http\Resources\PromotorResource;
use App\Http\Resources\UrgenciaAtendimentoResource;
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
        $espelho              = Espelho::query()->get();
        $promotores           = Promotor::query()->get();
        $grupoPromotorias     = GrupoPromotoria::query()->get();
        $promotorias          = Promotoria::query()->get();
        $eventos              = Evento::query()->get();
        $urgenciaAtendimentos = UrgenciaAtendimento::query()->get();

        return Inertia::render('Espelho/Editor', [
            'espelho'              => EspelhoResource::collection($espelho),
            'promotores'           => PromotorResource::collection($promotores),
            'grupoPromotorias'     => GrupoPromotoriaResource::collection($grupoPromotorias),
            'promotorias'          => PromotoriaResource::collection($promotorias),
            'eventos'              => EventoResource::collection($eventos),
            'urgenciaAtendimentos' => UrgenciaAtendimentoResource::collection($urgenciaAtendimentos),
        ]);
    }
}
