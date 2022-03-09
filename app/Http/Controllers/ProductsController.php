<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProductsRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductFilterService;

class ProductsController extends Controller
{
    public function all(GetProductsRequest $request)
    {
        return response()->success(ProductResource::collection(ProductFilterService::productsFiltered($request->search)));
    }
}
