<?php 

class Loader {

  private $load;

  protected $stack;
  protected $template;
  public $route;
  public $data;


  function __construct($route = NULL) {

    $this->route = $route;
    $this->load = $this;

    if ($route->cache_set) {
      $this->cache = new Cache();
    }

  }

  function setTemplate($file = '', $data = array()) {
    if (!$file) {
      $this->template['set'] = false;
    } else {
      $this->template['set'] = true;
      $this->template['file'] = $file;
      if(!empty($data)) {
        foreach($data as $key => $value) {
          $this->template['data'][$key] = $value;
        }
      }
    }
  }

  function templateData($key, $value) {
    $this->template['data'][$key] = $value;
  }

  function getFile($file, $data = array(), $format = 'html') {
    if(!empty($data)) {
      extract($data);
    }
    if(file_exists(BASE.'views/'.$format.'/'.$file.'.php')) {
      ob_start();
      include(BASE.'views/'.$format.'/'.$file.'.php');
      $content = ob_get_contents();
      ob_end_clean();
    } else {
      $content = '';
    }
    return $content;
  }   

  function view($file, $data = array(), $format = 'html'){
    $this->stack .= $this->getFile($file, $data, $format);
  }

  function setData($key, $value) {
    $this->data[$key] = $value;
  }

  function getData($key) {
    return $this->data[$key];
  }

  function render($string = '') {
    if($string != '') {
      $this->stack .= $string;
    } elseif($this->template['set'] == true) {
      $content = $this->stack;
      if(!empty($this->template['data'])) {
        extract($this->template['data']);
      }
      ob_start();
      include(BASE.'views/tpl/'.$this->template['file'].'.php');
      $obj = ob_get_contents();
      ob_end_clean();

      if ($this->route->cache_set) {
        $this->cache->create($this->route->url, $obj);
      }
      echo $obj;
    } elseif(!empty($this->stack)) {
      if ($this->route->cache_set) {
        $this->cache->create($this->route->url, $this->stack);
      }
      echo $this->stack;
    } else {
      echo '404';
    }
  }

}
