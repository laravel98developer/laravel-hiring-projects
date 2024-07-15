<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseJson;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::query()->get();

        if ($categories->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return ResponseJson::success($categories, "categories list", Response::HTTP_OK);
    }
}
