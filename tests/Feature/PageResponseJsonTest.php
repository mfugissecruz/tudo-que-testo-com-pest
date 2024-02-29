<?php

use App\Models\Product;

use function Pest\Laravel\get;

test('nossa api de produtos precisa retornar a lista de produtos')
    ->get('/api/products')
    ->assertOk()
    ->assertExactJson([
        ['title' => 'Product A'],
        ['title' => 'Product B'],
        ['title' => 'Product C'],
    ]);

test('json list products from database', function () {
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();

    get('/api/products')
        ->assertOk()
        ->assertJson([
            ['title' => 'Product A'],
            ['title' => 'Product B'],
            ['title' => 'Product C'],
            ['title' => $product1->title],
            ['title' => $product2->title]
        ]);
});
