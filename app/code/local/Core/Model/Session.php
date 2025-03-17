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
        // print("session status is ");
        // print(session_status());
        // // die;
        // echo '<pre>';
        // print_r(PHP_SESSION_ACTIVE);
        // echo '</pre>';
        // // $_SESSION["name"] = "nisarg";
        // print_r($_SESSION);
        // die;
        if (isset($_SESSION) && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
        // @session_start();

        // echo '<pre>';
        // print_r($_SESSION);
        // echo '</pre>';
    }
    public function set($key, $value)
    {
        print("in session set");
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
