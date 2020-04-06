<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\Product;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $url = 'https://7c77834b.ngrok.io';
    private $client_id = '785544960c0f37664c5c558a351c996d';
    private $client_secret = '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';

    public function index(Request $request)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);
        $response = $client->request('POST', "https://{$request->shop}/admin/oauth/access_token.json", [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $request->code,
            ]),
        ]);
        $data = (array)json_decode($response->getBody(), true);
        $data['shop'] = $request->shop;
        $shop = Shop::store($data);
        if($shop){
            $products = Product::get_shopify();
            foreach ($products as $key => $product) {
                $product['shop_id'] = $shop->id;
                Product::store($product);
            }
            $response = $client->request('POST', "https://{$request->shop}/admin/api/2020-04/script_tags.json", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' => $shop->access_token,
                ],
                'body' => json_encode([
                    'script_tag' => [
                        'event' => 'onload',
                        'src' => "{$this->url}/js/message.js",
                    ]
                ]),
            ]);
            // return redirect('shop/'.$shop->id);
            return redirect('https://'.$shop->shop.'/collections/all');
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop' => 'required|string',
        ]);
        $data = $request->except(['_token']);
        if (!preg_match('/(https|http)\:\/\/[a-zA-Z0-9][a-zA-Z0-9\-]*\.myshopify\.com[\/]?/', "https://{$data['shop']}.myshopify.com/")) {
            return response()->json([
                'code' => 422,
                'message' => 'The shop not valid',
            ], 422);
        }
//        $api_key = ;
//        $redirect_url = "";
//        $scopes = "read_orders,write_products";
        // https://{shop}.myshopify.com/admin/oauth/authorize?client_id={api_key}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}
        $query = [
            'client_id' => '785544960c0f37664c5c558a351c996d',
            'scope' => 'write_orders,read_customers,write_products,write_script_tags',
            'redirect_uri' => "{$this->url}/auth",
            'state' => rand(1, 1000),
            'grant_options[]' => '',
        ];
        $query = http_build_query($query);
        $data['url'] = "https://{$data['shop']}.myshopify.com/admin/oauth/authorize?{$query}";
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
