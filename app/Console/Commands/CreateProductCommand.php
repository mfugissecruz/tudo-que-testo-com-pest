<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateProductCommand extends Command
{
    protected $signature = 'app:create-product-command {title} {owner}';
    protected $description = 'Command description';

    public function handle(): void
    {
        $title = $this->argument('title');
        $owner = $this->argument('owner');

        Product::query()
            ->create([
                'title' => Str::title($title),
                'owner_id' => $owner,
                'code' => Str::slug($title)
            ]);
    }
}
