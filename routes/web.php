<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/404', fn () => ['oi']);
Route::get('/403', function () {
    abort_if(true, 403);

    return ['oi'];
});
Route::get('products', function () {
    return view('product.index')
        ->with([
            'products' => Product::all(),
        ]);
});

Route::post('product/store/', function () {
    Product::query()
        ->create(request()->only('title'));

    return response()->json('', 201);
})->name('product.store');

Route::post('product/update/{product}', function (Product $product) {
    $product->update(request()->only('title'));
})->name('product.update');

Route::delete('product/update/{product}', function (Product $product) {
    $product->delete();
})->name('product.destroy');
