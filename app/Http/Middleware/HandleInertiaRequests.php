<?php

namespace App\Http\Middleware;

use App\Models\Espelho;
use App\Models\Evento;
use App\Models\GrupoPromotoria;
use App\Models\Promotor;
use App\Models\Promotoria;
use App\Models\UrgenciaAtendimento;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'espelho' => [
                'all' => Espelho::query()
                    ->with('promotorias')
                    ->get()
                    ->toArray(),
            ],
            'promotores' => [
                'all' => Promotor::query()
                    ->with(['promotorias', 'eventos', 'urgenciasAtendimento'])
                    ->get()
                    ->toArray(),
            ],
            'promotorias' => [
                'all' => Promotoria::query()
                    ->with(['promotor', 'espelho', 'grupoPromotoria'])
                    ->get()
                    ->toArray(),
            ],
            'eventos' => [
                'all' => Evento::query()
                    ->with(['promotorTitular', 'promotorDesignado'])
                    ->get()
                    ->toArray(),
            ],
            'urgenciaAtendimentos' => [
                'all' => UrgenciaAtendimento::query()
                    ->with('promotor')
                    ->get()
                    ->toArray(),
            ],
            'grupoPromotoria' => [
                'all' => GrupoPromotoria::query()
                    ->with(['promotorias', 'promotorias.promotor', 'municipio'])
                    ->get()
                    ->toArray(),
            ],
        ];
    }
}
