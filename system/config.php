<?php 

class Config {

  protected static $params = array();
  protected  static $_instance;

  private function __construct() {
  }

  public static function getInstance() {
    if(is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public static function set($key, $value) {
    return static::$params[$key] = $value;
  }

  public static function get($key) {

    $array = &static::$params;

    if (strpos($key, ':') !== false) {
      $keys = explode(':', $key);
      foreach ($keys as $k) {
        $array = &$array[$k];
      }
      return isset(static::$params) ? static::$params : false;
    } 

    return isset(static::$params[$key]) ? static::$params[$key] : false;
  }

  public static function getAllArray() {
    foreach (static::$params as $key => $value) {
      $config[$key] = $value;
    }

    return $config;
  }

  public static function setArray($array) {
    foreach ($array as $key => $value) {
      self::set($key, $value);      
    }
  }

}
