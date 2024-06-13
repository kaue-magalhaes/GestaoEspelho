<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class PromotoriasController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $user = Auth::user();

        $this->authorize('isAdmin', $user);

        return inertia('Admin/Promotorias', [
            'promotorias' => Promotoria::query()
                ->with('promotor', 'grupoPromotoria', 'grupoPromotoria.municipio')
                ->orderBy('id')
                ->paginate(10),
        ]);
    }
}
