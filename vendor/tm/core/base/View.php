<?php

namespace tm\core\base;

class View
{
    public $route = [];


    public $view;

    public $layout;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        $this->layout = $layout ?: LAYOUT;
        $this->view = $view;
    }

    public function render($vars)
    {
        extract($vars);
        $fileView = APP . "/views/{$this->route['controller']}/{$this->view}.php";

        ob_start();

        if(is_file($fileView)){

            require $fileView;
        } else {
            http_response_code(404);
            include '404.html';
        }

        $content = ob_get_clean();

        $fileLayout  = APP . "/views/layouts/{$this->layout}.php";

        if(is_file($fileLayout)){

            require $fileLayout;
        } else {
            http_response_code(404);
            include '404.html';
        }
    }
}
