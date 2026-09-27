<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('report:stock')]
#[Description('Reports products whose number of available licenses in stock has fallen below 5.')]
class StockReportCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $products = Product::withCount(['Licenses as available_stock' => function ($query) {
            $query->whereNull('user_id');
        }])
            ->having('available_stock', '<', 5)
            ->get();

        if ($products->isEmpty()) {
            $this->info('There are no products with a stock quantity below 5.');

            return Command::SUCCESS;
        }

        $headers = ['ID', 'Product Name', 'Price ($)', 'Available Stock'];

        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->price, 2),
                'stock' => $product->available_stock,
            ];
        })->toArray();

        $this->table($headers, $data);

        return Command::SUCCESS;
    }
}
