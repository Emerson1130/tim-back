<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseForCreate($model): JsonResponse
    {
        return response()->json(['data' => ['id' => $model->id]]);
    }

    public function responseForUpdate(): Response
    {
        return response()->noContent();
    }

    public function responseForDelete(): Response
    {
        return response()->noContent();
    }

    public function responseForFind($model): JsonResponse
    {
        return response()->json(['data' => $model]);
    }

    public function responseForPaginator(Paginator $paginator): JsonResponse
    {
        return response()->json(['data' => $paginator]);
    }
}
