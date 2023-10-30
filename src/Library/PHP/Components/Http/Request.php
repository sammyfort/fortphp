<?php


namespace Fort\PHP\Http;


class Request
{
    private array $routeParams = [];

    public function getPath(){
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $pos = strpos($path, '?');
        if ($pos === false){
            return $path;
        }

       return substr($path, 0,$pos);
    }

    public function  method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(){
        $body = [];
        if ($this->method() === 'get'){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === 'post'){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function isPost()
    {
        return $this->method() === 'post';
    }
    public function isGet()
    {
        return $this->method() === 'get';
    }


    /**
     * @param $params
     * @return self
     */
    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function getRouteParam($param, $default = null)
    {
        return $this->routeParams[$param] ?? $default;
    }


}