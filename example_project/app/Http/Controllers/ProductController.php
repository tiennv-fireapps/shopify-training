<?php

namespace App\Http\Controllers;

use App\Message;
use App\Product;
use App\Shop;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $data['products'] = Product::select('products.*')
            ->join('shops', 'shops.id', '=', 'products.shop_id')
            ->where('shops.shop', $request->shop)
            ->get()
            ->keyBy('id');
        $data['messages'] = [];
        foreach ($data['products'] as $key => $product) {
            $data['messages'][$product->id] = $product->messages()->get();
        }
//        dd($data['messages']);
//        $data['messages'] = Product::select('messages.*')
//            ->join('shops', 'shops.id', '=', 'products.shop_id')
//            ->where('shops.shop', $request->shop)
//            ->orderBy('id', 'asc')
//            ->get();
        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data = [];
        $data['shop'] = Shop::get(['id'=>$product->shop_id]);
        $data['product'] = Product::gets(['id'=>$product->id]);
        $data['product'] = array_values($data['product'])[0];
//        $data['messages'] = Message::where('product_id', $product->id)->get();
        return view('product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
