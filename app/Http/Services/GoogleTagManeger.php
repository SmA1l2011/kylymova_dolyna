<?php

namespace App\Http\Services;

use App\Models\Product;

class GoogleTagManeger
{
    public function viewProductPage(Product $product) 
    {
        return [
            'event' => 'view_item',
            'ecommerce' => [
                'currency' => 'USD',
                'items' => [
                    'item_id' => $product->id,
                    'item_title' => $product->title,
                    'item_price' => $product->price,
                ]
            ]
        ];
    }
}