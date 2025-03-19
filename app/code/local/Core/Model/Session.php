<?php

class Core_Model_Session
{
    public function __construct()
    {
        ob_start();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function getId()
    {
        return session_id();
    }
    public function get($key)
    {
        if (isset($_SESSION) && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        } else {
            return "";
        }
    }
}
