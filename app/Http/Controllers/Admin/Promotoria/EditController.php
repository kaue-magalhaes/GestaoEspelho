<?php

namespace App\Http\Controllers\Admin\Promotoria;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotorResource;
use App\Models\Promotor;
use App\Models\Promotoria;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Promotoria $promotoria): Response
    {
        $user = Auth::user();
        $this->authorize('isAdmin', $user);

        $promotores = Promotor::query()->get();

        return Inertia::render('Admin/Promotoria/Edit', [
            'promotoria' => $promotoria->load('promotor', 'grupoPromotoria', 'grupoPromotoria.municipio'),
            'promotores' => PromotorResource::collection($promotores),
        ]);
    }
}
