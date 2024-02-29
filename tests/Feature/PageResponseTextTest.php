<?php

use App\Models\Product;

use function Pest\Laravel\get;

it('should list products')
    ->get('/products')
    ->assertOk()
    ->assertSee('Marcelo')
    ->assertSeeTextInOrder([
        'Product A',
        'Product B',
    ]);

test('must list products from database', function () {
    $product1 = Product::factory()->create();
    $product2 = Product::factory()->create();

    get('products')
        ->assertOk()
        ->assertSeeTextInOrder([
            'Product A',
            'Product B',
            $product1->title,
            $product2->title,
        ]);
});
