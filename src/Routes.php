<?php
namespace Ollyo\Task;

use Closure;
use Exception;

class Routes {
    private static $routes = [];
    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public static function get($path, Closure $callback) {
        static::$routes['GET'][$path] = $callback;
    }

    public static function post($path, Closure $callback) {
        static::$routes['POST'][$path] = $callback;
    }

    private function getRequest()
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        switch ($method) {
            case 'POST':
                return $_POST;
            case 'GET':
            default:
                return $_GET;
        }
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request = $this->getRequest();
        
        if (isset(static::$routes[$method][$path])) {
            $callback = static::$routes[$method][$path];

            if (!($callback instanceof Closure)) {
                throw new Exception(sprintf('The second parameter must be a Closure.'));
            }

            echo $callback($request);
            exit;
        }
        
        http_response_code(404);
        echo '404 Not Found';
        exit;
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = static::getInstance();

        if (in_array($method, ['get', 'post'])) {
            $instance->$method(...$arguments);
        }

        return $instance;
    }
}
