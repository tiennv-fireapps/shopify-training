<?php
/**
 * Created by PhpStorm.
 * User: buicongdang
 * Date: 7/24/19
 * Time: 9:54 AM
 */

namespace App\SpfApi;

use GuzzleHttp\Client;

class AuthApi extends BaseApi implements \App\Contract\SpfApi\AuthApi
{
    /**
     * @param array $data
     * @return bool
     */
    function verifyRequest(array $data) : bool
    {
        $tmp = [];
        if (is_string($data)) {
            $each = explode('&',$data);
            foreach($each as $e) {
                list($key, $val) = explode('=', $e);
                $tmp[$key] = $val;
            }
        } elseif(is_array($data)) {
            $tmp = $data;
        } else {
            return false;
        }

        // Timestamp check; 1 hour tolerance
        if(($tmp['timestamp'] - time() > 3600 ) )
            return false;


        if(array_key_exists('hmac', $tmp)) {
            // HMAC Validation
            $queryString = http_build_query([
                'code'      => $tmp['code'],
                'shop'      => $tmp['shop'],
                'timestamp' => $tmp['timestamp']
            ]);
            $match       = $tmp['hmac'];
            $calculated  = hash_hmac('sha256', $queryString, $this->_spfSecretKey);
            return $calculated === $match;
        }

        return false;
    }

    /**
     * @param $shop_domain
     * @return string
     */
    function urlInstall(string $shop_domain): string
    {
        $client_id = $this->_spfApiKey;
        $scopes = implode(',', config('shopify.scope'));
        $redirect_uri = config('shopify.redirect_url');

        return "https://{$shop_domain}.myshopify.com/admin/oauth/authorize?client_id={$client_id}&scope={$scopes}&redirect_uri={$redirect_uri}";
    }

    /**
     * @param $code
     * @return array
     */
    function getAccessToken(string $shop, string $code) : array
    {

        $client = new Client();
        try{
            $response = $client->request('POST', "https://{$shop}/admin/oauth/access_token.json",
            [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'code' => $code,
                    'client_id' => $this->_spfApiKey,
                    'client_secret' => $this->_spfSecretKey
                ])
            ]);
            return ['status' => true, 'data' => json_decode($response->getBody()->getContents(), true)];
        } catch (\Exception $exception) {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
