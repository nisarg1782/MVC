<?php
include("../MVC/app/code/local/autoload.php");
class Core_Controller_Front
{
    public function init()
    {
        $request = Mage::getModel("core/request");
        $class = $request->getModuleName() . "_Controller_" . $request->getControllerName();
        $class = ucwords($class, "_");
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";
        // print_r($class);
        $obj = new $class;
        $action = $request->getActionName() .'Action';
        $obj->$action();

    }
}
