<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductNotifcation;
use Illuminate\Support\Str;

class CreateProductAction
{
    public function handle(string $title, User $user): void
    {
        Product::query()->create([
            'owner_id' => $user->id,
            'title'    => $title,
            'code' => Str::slug($title),
        ]);

        $user
            ->notify(new NewProductNotifcation());

    }
}
