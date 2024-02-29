<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', function () {
    $products = Product::all();
    $products->map(fn($product) => ['title' => $product->title]);

    return array_merge([
        ['title' => 'Product A'],
        ['title' => 'Product B'],
        ['title' => 'Product C'],
    ], $products->toArray());
});
