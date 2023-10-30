<?php


namespace Fort\PHP\Builders;


use App\Controllers\UserController;
use Closure;
use Fort\Exception\RouteNotFoundException;
use Fort\PHP\Http\Request;
use Fort\PHP\Http\Response;


class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, callable|array $callback){

        $this->routes['get'][$path] = $callback;
    }

    public function post($path, callable|array $callback){

        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
      $path =  $this->request->getPath();
      $method = $this->request->method();
      $callback = $this->routes[$method][$path] ?? false;

      if ($callback === false){
          $this->response->setStatusCode(404);
          throw new  RouteNotFoundException();
      }



      if (is_string($callback)){
          return $this->renderView($callback);
      }
      if (is_callable($callback)){
          return call_user_func( $callback, $this->request);

      }

      if (is_array($callback)){
          [$class, $method] = $callback;
          $obj = new UserController();
          return call_user_func([$obj, 'index'], [$this->request, $this->response]);
//          if (class_exists($class)){
//              $class = new $class();
//          }
//
//          if (method_exists($class,$method)){
//              return call_user_func_array([$class, $method], [$this->request, $this->response]);
//          }
      }

      return 'null';
    }



    public function renderView(string $view, $data = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $data);
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    protected function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    public function renderOnlyView($view, $data)
    {
        foreach ($data as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/$view.php";
        return ob_get_clean();
    }



    private function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/layouts/$layout.php";
        return ob_get_clean();
    }


}