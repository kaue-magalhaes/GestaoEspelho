<?php

namespace App\Http\Controllers\API\UrgenciaAtendimentos;

use App\Http\Controllers\Controller;
use App\Http\Resources\UrgenciaAtendimentoResource;
use App\Models\UrgenciaAtendimento;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $urgenciaAtendimentos = UrgenciaAtendimento::query()->get();

        return UrgenciaAtendimentoResource::collection($urgenciaAtendimentos);
    }
}
