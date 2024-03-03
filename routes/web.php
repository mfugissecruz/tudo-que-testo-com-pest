<?php

use App\Actions\CreateProductAction;
use App\Jobs\ImportProductJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        'title' => ['required', 'max:255']
    ]);

    app(CreateProductAction::class)
        ->handle($request->input('title'), Auth::guard('web')->user());

    return response()->json('', 201);
})->name('product.store');

Route::post('product/update/{product}', function (Product $product) {
    $product->update(request()->only('title'));
})->name('product.update');

Route::delete('product/delete/{product}', function (Product $product) {
    $product->delete();
})->name('product.destroy');

Route::post('import-procucts', function (Request $request) {
    $data = $request->get('data');
    ImportProductJob::dispatch($data, Auth::guard('web')->user()->id);
})->name('product.import');

Route::post('sending-email/{user}', function (User $user) {
    Mail::to($user)->send(new WelcomeEmail($user));
})->name('sending-email');

