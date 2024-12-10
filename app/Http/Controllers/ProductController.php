<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    const CACHE_LIFETIME = 900;

    public function getProduct($id)
    {
        $key = 'product_' . $id;

        // $product = Cache::get($key);
        // if ($product === null) {
        //     $product = Product::find($id);
        //     Cache::put($key, $product, self::CACHE_LIFETIME);
        // }

        // $product = Cache::get($key, function() use($id, $key) {
        //     $product = Product::find($id);
        //     Cache::put($key, $product, self::CACHE_LIFETIME);
        //     // Cache::forever($key, $product);
        //     return $product;
        // });

        // $product = Cache::remember($key, self::CACHE_LIFETIME, function () use ($id){
        //     $product = Product::find($id);
        //     return $product;
        // });

        // if (Cache::has($key)){
        //     echo 'Tồn tại';
        // }else{
        //     echo 'Không tồn tại';
        //

        // $product = Product::find($id);
        // $product->view_count = Cache::increment('view_count');
        // $product->save();

        $product = Cache::rememberForever($key, function () use ($id) {
            return Product::find($id);
        });

        $product = Product::find($id);
        $product->view_count++;
        $product->save();

        Cache::increment('view' . $id);
        $viewCount = Cache::remember('view' . $id, self::CACHE_LIFETIME, function () use ($product) {
            return $product->view_count;
        });

        return view('products.detail', compact('product', 'viewCount'));
    }
}
