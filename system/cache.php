<?php 

class Cache {

  /* ToDo:
   *
   * Optional
   *
   *
   */

  protected $cache_dir;
  protected $expiration;
  protected $cache_content;
  protected $extension;
  public $needed = true;
  public $user_errors = array();

  public function __construct($path = '', $time = '') {

    $this->cache_content = false;

    $this->cache_dir = ($path === '') 
      ? $this->set_cache_dir(BASE.'cache/') 
      : $this->set_cache_dir($path);

    $this->expiration = ($time === '') 
      ? 3600
      : $this->set_cache_time($time);

    $this->extension = '.cache';

  }

  public function get($string) {
    $file = $this->process_file($string);
    if (file_exists($file) && filemtime($file) > time() - $this->expiration) {
      return file_get_contents($file);
    } else {
      return false;
    }
  }

  public function create($file, $content) {
    if ($this->needed) {
      file_put_contents($this->process_file($file), $content);
    }
  }

  protected function process_file($string) {

    $hash = $this->do_hash($string);
    $file = $this->cache_dir.$hash.$this->extension;

    return $file;

  }

  protected function set_cache_dir($path) {

    if ($this->check_dir($path)) {
      return $path;
    } else {
      trigger_error('La ruta de cache no está definida o no tiene permisos de escritura');
      return false;
    }

  }

  protected function set_cache_time($time) {

    if ($this->check_time($time)) {
      return $time;
    } else {
      trigger_error('Tiempo de cache no válido');
      return false;
    }

  }

  protected function check_dir($path) {
    return (is_dir($path) && is_writable($path)) ? true : false;
  }

  protected function check_time($number) {
    // time in seconds
    $min = '600'; // Less of that -> no cache
    $max = '86400'; // More... not yet
    return (is_numeric($number) && ($number > $min && $number < $max)) ? true : false;
  }

  protected function do_hash($string) {
    return md5($string);
  }

}
