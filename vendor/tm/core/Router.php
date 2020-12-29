<?php

namespace tm\core;

class Router
{

    protected  static $routes = [];
    protected  static $route = [];

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    static public function matchRoute($url)
    {
       foreach (self::$routes as $pattern => $route){

           if(preg_match("#$pattern#i", $url, $matches)){

               foreach ($matches as $key => $value){

                   if(is_string($key)){
                       $route[$key] = $value;
                   }
               }

               if(!isset($route['action'])){

                   $route['action'] = 'index';
               }

               $route['controller'] = self::upperCamelCase($route['controller']);

               self::$route = $route;

               return true;
           }
       }

       return false;

    }

    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);

        if(self::matchRoute($url)){

            $controller = 'app\controllers\\' .  self::$route['controller'] . 'Controller';

            if(class_exists($controller)){

               $controllerObject = new $controller(self::$route);
               $action = self::lowerCamelCase(self::$route['action']);

               if(method_exists($controllerObject, $action)){

                   $controllerObject->$action();
                   $controllerObject->getView();
               } else {

                   http_response_code(404);
                   include '404.html';
               }
            } else {

                http_response_code(404);
                include '404.html';
            }
        } else {

            http_response_code(404);
            include '404.html';
        }

    }

    protected static function upperCamelCase($title)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $title)));
    }

    protected static function lowerCamelCase($title)
    {
        return lcfirst(self::upperCamelCase($title));
    }

    protected static function removeQueryString($url)
    {
        if($url){
            $params = explode('?', $url, 2);

            if(false === strpos($params[0], '=')){

                return rtrim($params[0], '/');
            } else {
                return '';
            }
        }

    }
}