<?php
class Mage
{
    public static function init()
    {
        $front = new Core_Controller_Front();
        $front->init();
    }
    public static function getModel($className)
    {
        $class = str_replace("/", "_Model_", $className);
        $class = ucwords($class,'_');
       
        return new $class;
    }
    public static function getBlock($className)
    {
        $class = str_replace("/", "_Block_", $className);
        $class = ucwords($class,'_');
        // echo $class;
        return new $class;
    }
    public static function getBaseDir()
    {
        return 'C:/xampp/htdocs/MVC/';

    }
    public static function getBaseUrl()
    {
        return "http://localhost/MVC/";
    }
}
