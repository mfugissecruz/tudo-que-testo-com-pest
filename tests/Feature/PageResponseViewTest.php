<?php

test('the route produtcs using view products')
    ->get( 'products')
    ->assertViewIs('product.index');

test('the route products its parsing a product list to list to products view')
    ->get('products')
    ->assertViewIs('product.index')
    ->assertViewHas('products');
