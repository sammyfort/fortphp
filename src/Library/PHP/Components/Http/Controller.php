<?php


namespace Fort\PHP\Http;


use Fort\PHP\Builders\Application;

class Controller
{
    public string $layout = 'app';

    public function setLayout($layout){
        $this->layout = $layout;

    }

    public function render($view, $data = []){
        return Application::$app->router->renderView($view, $data);
    }

}