<?php 
class Controller {

    protected $controller;
    protected $view; 
    protected $format;
    protected $args;
    protected $params;

    protected $load;

    function __construct() {

      $route = Config::get('route');

        $this->route = $route;

        $this->controller = $route->controller;
        $this->view = $route->view;
        $this->format = $route->format;
        $this->args = $route->args;
        $this->params = $route->params;

        $loader = new Loader($route);
        $this->load = $loader;

    }

    function __destruct() {
        $this->load->render();
    }

}
