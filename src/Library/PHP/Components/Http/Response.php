<?php


namespace Fort\PHP\Http;


class Response
{
    public function setStatusCode(int $code){
        http_response_code($code);

    }

}