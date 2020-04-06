<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable = [
        'shop',
        'access_token',
        'scope',
    ];

    public static function store($data)
    {
        $shop = Shop::where('shop', $data['shop'])->first();
        if ($shop) {
            Shop::where(['shop' => $data['shop']])->update($data);
            $shop = Shop::where('shop', $data['shop'])->first();
        } else {
            $shop = Shop::create($data);
        }
        return $shop;
    }

    public static function get($where = [])
    {
        if(empty($where)){
            return Shop::first();
        }
        $shop = Shop::where($where)->get();
        return $shop[0];
    }
}
