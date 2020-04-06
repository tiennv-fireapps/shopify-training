<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    //
    protected $fillable = [
        'shop_id',
        'shopify_id',
        'title',
        'body_html',
        'product_type',
        'shopify_created_at',
        'handle',
        'shopify_updated_at',
        'published_at',
        'template_suffix',
        'published_scope',
        'tags',
        'admin_graphql_api_id',
        'variants',
        'options',
        'images',
        'image',
    ];

    public static function gets($where = [])
    {
        $products = Product::where($where)->get();
        $products = $products ? $products->toArray() : [];
        $data = [];
        foreach ($products as $key => $product) {
            $product['variants'] = (array) json_decode($product['variants'], true);
            $product['options'] = (array) json_decode($product['options'], true);
            $product['images'] = (array) json_decode($product['images'], true);
            $product['image'] = (array) json_decode($product['image'], true);
            $data[$product['id']] = $product;
        }
        return $data;
    }

    public static function store($product)
    {
        $product['shopify_id'] = $product['id'];
        $product['shopify_created_at'] = $product['created_at'];
        $product['shopify_updated_at'] = $product['updated_at'];
        $product['variants'] = json_encode($product['variants']);
        $product['options'] = json_encode($product['options']);
        $product['images'] = json_encode($product['images']);
        $product['image'] = json_encode($product['image']);

        unset($product['id']);
        unset($product['created_at']);
        unset($product['updated_at']);

        $product['published_at'] = date('Y-m-d H:i:s', strtotime($product['published_at']));
        $product['shopify_created_at'] = date('Y-m-d H:i:s', strtotime($product['shopify_created_at']));
        $product['shopify_updated_at'] = date('Y-m-d H:i:s', strtotime($product['shopify_updated_at']));
        $data = Product::where('shopify_id', $product['shopify_id'])->first();
        if ($data) {
            Product::where(['shopify_id' => $product['shopify_id']])->update($product);
            $data = Product::where('shopify_id', $product['shopify_id'])->first();
        } else {
            $data = Product::create($product);
        }
        return $product;
    }

    public static function get_shopify($shop = null)
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);
        $shop = $shop ? $shop : Shop::get();
        $response = $client->request('GET', "https://{$shop->shop}/admin/api/2020-04/products.json", [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => $shop->access_token,
            ],
        ]);
        $response = (array)json_decode($response->getBody()->getContents(), true);
        return $response['products'];
    }
}
