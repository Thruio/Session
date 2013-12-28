<?php

namespace FourOneOne;

class SessionHandler implements \SessionHandlerInterface
{

  public function open($savePath, $sessionName) {
    return true;
  }

  public function close(){
    return true;
  }

  public function read($id){
    /* @var $session \session_model */
    $session = \session_model::search()->where('php_id', $id)->execOne();
    return unserialize($session->data);
  }

  public function write($id, $data){
    /* @var $session \session_model */
    $session = \session_model::search()->where('php_id', $id)->execOne();
    if(!$session instanceof \session_model){
      $session = new \session_model();
    }
    $session->php_id = $id;
    $session->data = serialize($data);
    $session->created = date("Y-m-d H:i:s");
    return true;
  }

  public function destroy($id){
    /* @var $session \session_model */
    $session = \session_model::search()->where('php_id', $id)->execOne();
    $session->delete();
    return true;
  }

  public function gc($maxlifetime){
    $created = date("Y-m-d H:i:s", time() - $maxlifetime);
    foreach(\session_model::search()->where('created', $created, '<')->exec() as $session){
      /* @var $session \session_model */
      $session->delete();
    }
    return true;
  }
}

