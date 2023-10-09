<?php


namespace Fort\PHP\Contracts\Http;
use Fort\PHP\Contracts\Http\Requests as HttpRequest;

abstract class Fort
{
    use HttpRequest;

    public static function get(string $uri,  array $headers = null, array $config = null){

        return self::getRequest($uri, $headers, $config);
    }

    public static function post(string $uri, array $data,  array $headers = null){

        return self::postRequest($uri, $data, $headers);
    }

    public static function put(string $uri, array $data,  array $headers = null){

        return self::putRequest($uri, $data, $headers);
    }

}