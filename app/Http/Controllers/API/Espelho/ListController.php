<?php

namespace App\Http\Controllers\API\Espelho;

use App\Http\Controllers\Controller;
use App\Models\Espelho;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $espelhos = Espelho::first();

        return $espelhos;
    }
}
