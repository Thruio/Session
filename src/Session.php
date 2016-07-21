<?php
namespace Thru\Session;

class Session
{
    private static $_instance;
    const lifetime = 86400;

    public function __construct(\SessionHandlerInterface $sessionHandler = null)
    {
        if(!$sessionHandler){
            $sessionHandler = new MySQLSessionHandler();
        }
        // server should keep session data for AT LEAST 1 day
        ini_set('session.gc_maxlifetime', Session::lifetime);

        // each client should remember their session id for EXACTLY 1 day
        session_set_cookie_params(Session::lifetime);

        session_set_save_handler($sessionHandler);

        // Begin the Session
        @session_start();
    }

    public static function get_session()
    {
        if (!self::$_instance instanceof Session) {
            self::$_instance = new Session();
        }
        return self::$_instance;
    }

    public static function get($key)
    {
        return Session::get_session()->_get($key);
    }

    public static function set($key, $value)
    {
        return Session::get_session()->_set($key, $value);
    }

    public static function dispose($key)
    {
        return Session::get_session()->_dispose($key);
    }

    public function _get($key)
    {
        if (isset($_SESSION[$key])) {
            return unserialize($_SESSION[$key]);
        } else {
            return false;
        }
    }

    public function _set($key, $value)
    {
        $_SESSION[$key] = serialize($value);
        return true;
    }

    public function _dispose($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }
}
