<?php


namespace Fort\Exception;



class ErrorHandler
{
    protected mixed $message;
    protected int $code;

    public function throw(mixed $message, int $code){
        $this->message = $message;
        $this->code = $code;
        http_response_code($code);
        ob_start();
        include_once 'template/exception.php';
        return ob_get_clean();
    }





}