<?php


namespace Fort\PHP\Http;


class Response
{
    public function setStatusCode(int $code): bool|int
    {
       return http_response_code($code);

    }

    public static function set(string $message, int $code = 200): mixed
    {
        $c = new Response();
        $c->setStatusCode($code);
        return $message;
    }

}