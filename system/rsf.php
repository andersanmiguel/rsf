<?php
define('SYSTEM', realpath(dirname(__FILE__)).'/../system/');
define('BASE', realpath(dirname(__FILE__)).'/../application/');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest") {
  define('AJAX_REQUEST', 1);
} else {
  define('AJAX_REQUEST', 0);
}
/* 
    Conditionals for load the enviroment config
    Ej: if ($_SERVER['SERVER_NAME'] == 'localhost') { ... }
 */
if ($_SERVER['SERVER_NAME'] == 'production_server.com') {
  define('ENVIROMENT', 'production');
} else {
  define('ENVIROMENT', 'development');
}
require BASE.'conf/'.ENVIROMENT.'_config.php';

define('ASSETS', $config['install_route'].'/public');
define('MAIN', $config['install_route']);

require SYSTEM.'autoload.php';
require BASE.'/conf/routes.php';

Config::set('routes', $routes);
Config::setArray($config);

//
// La ruta
$request = $_SERVER['REQUEST_URI'];
// echo $request.'<br />';
$request = preg_replace(':'.$config['install_route'].':', '', $_SERVER['REQUEST_URI']);

if (Config::get('cache_active') === true) {
  $cache = new Cache;
  $content_cached = $cache->get($_SERVER['REQUEST_URI']);
  if ($content_cached) {
    echo $content_cached;
    exit;
  } else {
    if (Config::get('cache_display_errors')) {
      // In the future... a class to show errors.
      echo '<pre>';
      print_r($cache->user_errors);
      echo '</pre>';
    }
  }
}

$route = new Router($request);

/* On demand routes */
// $route->any('/controller/action', array( 
//   'controller' => 'other_controller', 
//   'view' => 'other_action'
// ));

Config::set('route', $route);

// Debug.
// echo $request.'<br />';
// 
// echo 'Controller: '.$route->controller.'<br />';
// echo 'View: '.$route->view.'<br />';
// echo 'Format: '.$route->format.'<br />';
// echo '<pre>';
// print_r($route->args);
// echo '</pre>';
// echo '<pre>';
// print_r($route->params);
// echo '</pre>';

if (is_readable(BASE.'controller/'.$route->controller.'.php')) {

  $controller = ucfirst($route->controller);
  $view = $route->view;

  $c = new $controller();
  $c->{$view}();

} else {

  $view = $route->view;

  $c = new Mapper();
  $c->{$view}($request);

}

