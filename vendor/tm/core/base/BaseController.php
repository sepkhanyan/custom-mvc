<?php

namespace tm\core\base;

abstract class BaseController
{
    public $route = [];
    public $view;
    public $layout;
    public $vars = [];

    public function __construct($route)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->route = $route;
        $this->view = $route['action'];
    }


    public function getView()
    {
        $view = new View($this->route, $this->layout, $this->view);
        $this->vars['auth'] = $this->isLogged();
        $view->render($this->vars);
    }

    public function setVars($vars)
    {
        $this->vars = $vars;
    }

    public function isLogged()
    {
        if(isset($_SESSION['user_id']) &&  $_SESSION['user_id']){
            return true;
        }

        return false;
    }

}