<?php

namespace App\Http\Middleware;

use App\Models\GrupoPromotoria;
use App\Models\Historico\HistoricoPromotor;
use App\Models\Promotor;
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
        $user = $request->user();

        if ($user) {
            $user = $user->isAdmin() ? $user->toArray() + ['is_admin' => true] : $user->toArray();
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
            ],
            'promotores' => Promotor::query()
                ->get()
                ->toArray(),
            'grupoPromotorias' => GrupoPromotoria::query()
                ->get()
                ->toArray(),
            'historicoPromotores' => HistoricoPromotor::query()
                ->get()
                ->toArray(),
            'urgenciaAtendimentos' => UrgenciaAtendimento::query()
                ->get()
                ->toArray(),
        ];
    }
}
