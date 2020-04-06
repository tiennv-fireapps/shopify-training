<?php

namespace App\Http\Controllers;

use App\Message;
use App\Product;
use App\Shop;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        if($request->has('shopify_id')){
            $data['messages'] = Message::select('messages.*')
                ->join('products', 'products.id', '=', 'messages.product_id')
                ->where('products.shopify_id', $request->shopify_id)
                ->orderBy('id', 'asc')
                ->get();
            $data['messages'] = $data['messages'] ? $data['messages']->toArray() : [];
            return $data['messages'];
        }
        if($request->has('product_id')){
            $data['messages'] = Message::where('product_id', $request->product_id)->orderBy('id', 'asc')->get();
            $data['messages'] = $data['messages'] ? $data['messages']->toArray() : [];
            return $data['messages'];
        }
        $data['shop'] = Shop::get();
        $data['messages'] = Message::orderBy('id', 'asc')->get();
        $data['messages'] = $data['messages'] ? $data['messages']->toArray() : [];
        $data['products'] = Product::gets();
        return view('message.index', $data);
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
        $request->validate([
            'product_id' => 'required|integer',
            'content' => 'required|string',
        ]);
        $data = $request->except(['_token']);
        return Message::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
