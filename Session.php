<?php

namespace FourOneOne;

class Session
{
  static $instance;

  public function __construct(){
    session_start();
  }

  public function get_session(){
    if(!self::$instance instanceof Session){
      self::$instance = new Session();
    }
    return self::$instance;
  }

  static public function get($key){
    return Session::get_session()->_get($key);
  }

  static public function set($key, $value){
    return Session::get_session()->_set($key, $value);
  }

  public function _get($key){
    return $_SESSION[$key];
  }

  public function _set($key, $value){
    return $_SESSION[$key] = $value;
  }
}