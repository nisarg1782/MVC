<?php

class Core_Model_Request
{
    protected $_moduleName = "";
    protected $_controllerName = "";
    protected $_actionName = "";
    public function __construct()
    {
        $uri = $this->getRequestUri();
        $uri = array_filter(explode("/", $uri));
        $this->_moduleName = isset($uri[0]) ? $uri[0] : 'cms';
        $this->_controllerName = isset($uri[1]) ? $uri[1] : 'index';
        $this->_actionName = isset($uri[2]) ? $uri[2] : 'index';
    }
    public function getRequestUri()
    {
        $strurl = $_SERVER['REQUEST_URI'];
        $strurl = str_replace("/MVC/", "", $strurl);
        return $strurl;
    }
    public function getModuleName()
    {
        return $this->_moduleName;
    }
    public function getControllerName()
    {
        return $this->_controllerName;
    }
    public function getActionName()
    {
        return $this->_actionName;
    }
    public function  getQuery($field = null)
    {
        if ($field === null) {
            return $_GET;
        }
        if (isset($_GET[$field])) {
            return $_GET[$field];
        } else {
            return "";
        }
    }
    public function getParam($field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        } else {
            return "";
        }
    }
    public function getParams()
    {
        return $_POST;
    }
    //public function identifyRequest()
    // {
    //     if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //         return "ajax";
    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         return "post";
    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //         return "get";
    //     } else {
    //         echo "Unknown request type";
    //     }
    // }
    public function is_Ajax()
    {
        // echo "<pre>";
        // for($i=0;$i<10;$i++)
        // {
        //     print("<br>");
        // }
        // print_r($_SERVER);
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
    public function is_Post()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return True;
        } else {
            return false;
        }
    }
    public function is_Get()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return True;
        } else {
            return false;
        }
    }
}
