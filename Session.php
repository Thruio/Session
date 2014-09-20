<?php
namespace Thru;
require_once("SessionHandler.php");

class Session
{
  static $instance;

  public function __construct(){

    @session_start();
  }

  static public function get_session(){
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

  static public function dispose($key){
    return Session::get_session()->_dispose($key);
  }

  public function _get($key){
    if(isset($_SESSION[$key])){
      return unserialize($_SESSION[$key]);
    }else{
      return false;
    }
  }

  public function _set($key, $value){
    $_SESSION[$key] = serialize($value);
    //echo "<pre>"; var_dump($_SESSION);exit;
    return true;
  }

  public function _dispose($key){
    if(isset($_SESSION[$key])){
      unset($_SESSION[$key]);
      return true;
    }else{
      return false;
    }
  }
}