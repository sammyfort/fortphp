<?php
use App\Controllers\UserController;
use Fort\PHP\Builders\Application;
use Fort\PHP\Contracts\Http\HttpRequests;
use Fort\PHP\Support\Http;


require_once __DIR__ . "/vendor/autoload.php";
//\Dotenv\Dotenv::createImmutable(__DIR__)->load();

$app = new Application(dirname(__FILE__));

 $mail = new \Fort\PHP\Support\Mail();

 $send = $mail->from('hello@velstack.com', 'Velstack Tech')
     ->to('thesamuelfort@gmail.com', 'Sammy Fort')
     ->subject('Package test')
     ->replyTo('sam@velstack.com')

     ->send();

 print_r($send);






