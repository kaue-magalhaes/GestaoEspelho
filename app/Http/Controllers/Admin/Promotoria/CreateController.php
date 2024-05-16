<?php

namespace App\Http\Controllers\Admin\Promotoria;

use App\Http\Controllers\Controller;
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

        return Inertia::render('Admin/Promotoria/Create');
    }
}
