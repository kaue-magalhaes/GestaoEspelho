<?php

namespace App\Http\Controllers\Admin\Promotoria;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotorResource;
use App\Models\Promotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $user = Auth::user();
        $this->authorize('isAdmin', $user);

        $promotores = Promotor::query()->get();

        return Inertia::render('Admin/Promotoria/Create', [
            'promotores' => PromotorResource::collection($promotores),
        ]);
    }
}
