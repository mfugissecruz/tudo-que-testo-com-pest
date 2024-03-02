<?php

use App\Jobs\ImportProductJob;
use App\Mail\WelcomeEmail;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotifcation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

    $title = $request->input('title');

    Product::query()->create([
        'owner_id' => Auth::guard('web')->user()->id,
        'title'    => $title,
        'code' => Str::slug($title),
    ]);

    Auth::guard('web')
        ->user()
        ->notify(new NewProductNotifcation());

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

