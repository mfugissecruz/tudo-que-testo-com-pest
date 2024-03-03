<?php

use App\Console\Commands\CreateProductCommand;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;

test('should be able to create a product via command', function () {
    $user = User::factory()->create();

    actingAs($user);

    artisan(
        CreateProductCommand::class,
        ['title' => 'Product 1', 'owner' => $user->id]
    )->assertSuccessful();

    assertDatabaseHas('products', ['title' => 'Product 1', 'owner_id' => $user->id]);
    assertDatabaseCount('products', 1);
});
