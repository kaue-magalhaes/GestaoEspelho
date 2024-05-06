<?php

namespace App\Http\Controllers\Admin\Promotoria;

use App\Http\Controllers\Controller;
use App\Models\Promotoria;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Promotoria $promotoria): \Inertia\Response
    {
        $user = Auth::user();

        $this->authorize('isAdmin', $user);

        return Inertia::render('Admin/Promotoria/Edit', [
            'promotoria' => $promotoria,
        ]);
    }
}
