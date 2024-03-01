<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\assertTrue;

test('model relationship :: product owner should be an user', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create(['owner_id' => $user->id]);

    $owner = $product->owner;

    expect($owner)
        ->toBeInstanceOf(User::class);
});

test('model get mutator :: product title should be str()->title()', function() {
    $product = Product::factory()->create(['title' => 'título']);

    expect($product)
        ->title->toBe('Título');
});

test('model set mutator :: product code should be encrypted', function() {
    $product = Product::factory()->create(['code' => 'jetete']);

    assertTrue(Hash::isHashed($product->code));
});

test('model scopes :: should bring only released products', function () {
    Product::factory()->count(10)->create(['released' => true]);
    Product::factory()->count(5)->create(['released' => false]);

    expect(Product::query()->released()->get())
        ->toHaveCount(10);
});
