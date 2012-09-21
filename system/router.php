<?php 

class Router {

  private $routes;
  private $logic;

  public $url;
  public $params;
  public $format;
  public $view;
  public $controller;
  public $args;

  public $cache_set = false;

  function __construct($URL) {
    $this->url = $URL;
    $this->routes = Config::get('routes');
    $this->parse_url();

    $this->set_cache(Config::get('cache_active'));
  }

  public function parse_url() {
    $params = explode('?', $this->url);

    if (count($params) > 2) {
      trigger_error('URL:bad_url:?:url mal formada', E_USER_ERROR);
    } elseif(count($params) == 2) {
      $this->params = $this->parse_params($params[1]);
      $this->logic = $this->parse_logic($params[0]);
    } else {
      $this->logic = $this->parse_logic($params[0]);
    }

  }

  private function parse_params($params) {
    if($params == '') {
      return $param = NULL;
    } else {
      $params = explode('&', $params);

      foreach($params as $row) {
        $values = explode('=', $row);
        if (count($values) > 1) {
          $param[$values[0]] = $values[1];
        } else {
          $param[$values[0]] = true;
        } 

      }

      return $param;
    }
  }

  private function parse_logic($logic) {

    $extension = explode('.', $logic);
    if(count($extension) > 2) {
      $this->format = NULL;
      trigger_error('URL:bad_url:.:más de un punto en la url', E_USER_ERROR);
    } elseif(count($extension) == 2) {
      $this->format = ($extension[1] == '') ? $this->routes['default_format'] : $extension[1];
    } else {
      $this->format = $this->routes['default_format'];
    } 

    $parts = explode('/', $extension[0]);
    array_shift($parts);

    if (isset($this->routes['spaces']) && is_array($this->routes['spaces'])) {
      foreach ($this->routes['spaces'] as $space) {
        if (!isset($parts[1]) || $parts[1] == '') {

        } elseif ($parts[0] == $space) {
          $parts[0] = $parts[0].'_'.$parts[1];
          unset($parts[1]);
          $parts = array_values($parts);
        }            
      }
    }

    $this->controller = ($parts[0] == '') ? $this->routes['default_controller'] : $parts[0];
    if(count($parts) > 1) {
      $this->view = ($parts[1] == '') ? $this->routes['default_view'] : $parts[1];
    } else {
      $this->view = $this->routes['default_view'];
    }

    if(count($parts) > 2) {
      $this->args = array_slice($parts, 2);
    }


  }

  public function any($request, $ack = '') {

    if ($request == $this->url) {
      $e = $ack;
      if (is_string($e)) {
        echo $e;
        exit;
      } elseif (is_array($e)) {
        $this->controller = isset($e['controller']) ? $e['controller'] : $this->controller;
        $this->view = isset($e['view']) ? $e['view'] : $this->view;
        $this->format = isset($e['format']) ? $e['format'] : $this->format;
      }
    }

  }

  public function set_cache($arg) {
    $this->cache_set = $arg;
  }

}
