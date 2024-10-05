<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Luigel\Paymongo\Facades\Paymongo;
class PaymentController extends Controller
{
    public function pay()
    {

    $client = new \GuzzleHttp\Client();

    $response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
    'body' => '{"data":{"attributes":{"amount":10000,"redirect":{"success":"http://127.0.0.1:8000/success","failed":"http://127.0.0.1:8000/failed"},"type":"gcash","currency":"PHP"}}}',
    'headers' => [
        'accept' => 'application/json',
        'authorization' => 'Basic c2tfdGVzdF9rWDJzMnBDTmVzczM1TUxVNFM4V2ZTUTU6',
        'content-type' => 'application/json',
    ],
    ]);

    echo $response->getBody();
        }
    public function success()
    {

    }
}
