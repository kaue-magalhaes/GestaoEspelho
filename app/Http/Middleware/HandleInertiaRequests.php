<?php

namespace App\Http\Middleware;

use App\Models\Espelho;
use App\Models\Evento;
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
    public function version(Request $request): string|null
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
                'all' => optional(Espelho::with('promotorias')->first())->toArray(),
            ],
            'promotores' => [
                'all' => Promotor::all()->toArray(),
            ],
            'promotorias' => [
                'all' => Promotoria::all()->toArray(),
            ],
            'eventos' => [
                'all' => Evento::all()->toArray(),
            ],
            'urgenciaAtendimentos' => [
                'all' => UrgenciaAtendimento::all()->toArray(),
            ],
        ];
    }
}
