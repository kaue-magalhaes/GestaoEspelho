<?php

namespace App\Http\Controllers\API\Promotores;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotorResource;
use App\Models\Promotor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $promotores = Promotor::query()->get();

        return PromotorResource::collection($promotores);
    }
}
