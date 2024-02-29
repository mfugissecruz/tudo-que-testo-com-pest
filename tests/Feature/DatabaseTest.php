<?php

use App\Models\Product;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('should be able to create a product', function () {
    post(
        route('product.store'),
        ['title' => 'Livro: Escolha ser filho']
    )->assertCreated();

    assertDatabaseHas('products', ['title' => 'Livro: Escolha ser filho']);
    assertDatabaseCount('products', 1);
});

it('should be able to update a product', function () {
    $product = Product::factory()->create(['title' => 'Livro: Escolha ser filho']);

    postJson(
        route('product.update', $product),
        ['title' => 'Livro: Cristinismo Puro e Simples']
    )->assertOk();

    assertDatabaseHas('products', [
        'id' => $product->id,
        'title' => 'Livro: Cristinismo Puro e Simples',
    ]);

    assertDatabaseCount('products', 1);
});

it('should be able to delete a product', function () {
    $product = Product::factory()->create(['title' => 'Livro: Escolha ser filho']);

    delete(route('product.destroy', $product))
        ->assertOk();

    assertDatabaseMissing('products', $product->toArray());

    assertDatabaseCount('products', 0);
});
