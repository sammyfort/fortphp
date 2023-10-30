<?php
use \App\Controllers\UserController;
use Fort\PHP\Builders\Application;
require_once __DIR__ . "/vendor/autoload.php";
//\Dotenv\Dotenv::createImmutable(__DIR__)->load();





use Fort\PHP\Contracts\Http\HttpRequests;

use Fort\PHP\Support\Http;

$headers = 'Accept: application/json';
$headers_array = ['Accept' => 'application/json'];

$get = Http::get('https://sms.velstack.com/api/group',
    [
        'Accept' => 'application/json',
        'Authorization'=> 'Bearer sk_live_uA6FwrbpfQ8QQn4wSoHvYXFJNWU9PrZlE4jhoP4x'
    ],

);

$post = Http::post('https://sms.velstack.com/api/quick/sms', [],
    [
        'Accept' => 'application/json',
        'Authorization'=> 'Bearer sk_live_uA6FwrbpfQ8QQn4wSoHvYXFJNWU9PrZlE4jhoP4x'
    ]
);

print_r($get);









