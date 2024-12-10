<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    const CACHE_LIFETIME = 900;

    public function getProduct($id){
       $key = 'product_'.$id;

    //    $product = Cache::get($key);
    //    if($product === null){
    //         $product = Product::find($id);
    //         Cache::put($key, $product, self::CACHE_LIFETIME);
    //    }

        $product = Cache::get($key, function() use($id, $key) {
            $product = Product::find($id);
            // Cache::put($key, $product, self::CACHE_LIFETIME);
            Cache::forever($key, $product);
            return $product;
        });

        return view('products.detail', compact('product'));
    }
}
