<?php

use App\Models\Product;
use Illuminate\Http\Request;
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

Route::post('product/store/', function (Request $request) {
    $request->validate([
        'owner_id' => ['required', 'exists:users,id'],
        'title' => ['required', 'max:255'],
    ]);

    Product::query()->create([
        'owner_id' => $request->input('owner_id'),
        'title'    => $request->input('title'),
    ]);

    return response()->json('', 201);
})->name('product.store');

Route::post('product/update/{product}', function (Product $product) {
    $product->update(request()->only('title'));
})->name('product.update');

Route::delete('product/update/{product}', function (Product $product) {
    $product->delete();
})->name('product.destroy');
