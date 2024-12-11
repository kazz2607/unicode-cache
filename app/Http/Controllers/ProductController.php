<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    const CACHE_LIFETIME = 900;

    public function index()
    {
        // $value = Cache::remember('users', self::CACHE_LIFETIME, function(){
        //     return [
        //         'User 1',
        //         'User 2',
        //         'User 3',
        //     ];
        // });

        // $value = cache('users');

        $data = [
            'User 1',
            'User 2',
            'User 3',
        ];

        // Cache::tags(['tag1', 'tag2'])->put('name', 'Unicode', self::CACHE_LIFETIME);
        // Cache::tags(['tag1', 'tag2'])->put('age', '30', self::CACHE_LIFETIME);



        // cache(['users' => $data], Carbon::now()->addSeconds(10));

        $value = cache()->remember('users', self::CACHE_LIFETIME, function() use ($data){
            return $data;
        });

        dd($value);
    }

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

        Cache::increment('view_' . $id);

        $viewCount = Cache::remember('view_' . $id, self::CACHE_LIFETIME, function () use ($product) {
            return $product->view_count;
        });

        // $viewCount = Cache::pull('view' . $id);

        return view('products.detail', compact('product', 'viewCount'));
    }

    public function forgetCache($id)
    {
        $key1 = 'product_' . $id;
        $key2 = 'view_' . $id;
        Cache::forget($key1);
        Cache::forget($key2);
    }

    public function flushCache()
    {
        Cache::flush();
    }
}
