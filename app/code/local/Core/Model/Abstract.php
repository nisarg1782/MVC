<?php
class Core_Model_Abstract
{
    protected $_resourceClassName = "";
    protected $_collectionClassName = "";
    protected $_data = [];
    protected $_extradata = [];
    public function init() {}
    public function __construct()
    {
        $this->init();
    }
    public function getResource()
    {
        return new  $this->_resourceClassName;
    }
    public function __get($name)
    {
        return isset($this->_data[$name]) ? $this->_data[$name] : "";
    }
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }
    public function setdata($data)
    {
        $this->_data = $data;
        return $this;
    }
    // public function setadddata($data)
    // {
    //     $this->_extradata[] = $data;
    //     return $this;
    // }
    // public function getadddata()
    // {
    //     return $this->_extradata;
    // }
    public function getdata()
    {
        return $this->_data;
    }
    public function __call($method, $args)
    {
        $f = substr($method, 0, 3);
        if ($f == 'get' && strpos($method, "_") === FALSE) {
            $value = substr($method, 3);
            $field = $this->camelToSnake($value);

            return isset($this->_data[$field]) ? $this->_data[$field] : "";
        } else if ($f == 'set' && strpos($method, "_") === FALSE) {
            $value = substr($method, 3);
            $field = $this->camelToSnake($value);

            $this->_data[$field] = $args[0];
            return $this;
        }

        throw new Exception('invalid method');
    }
    public function camelToSnake($input)
    {
        $snakeCase = preg_replace_callback(
            '/[A-Z]/',
            function ($matches) {
                return '_' . strtolower($matches[0]);
            },
            $input
        );
        return ltrim($snakeCase, '_');
    }
    public function load($value, $field = null)
    {
        $this->_data = $this->getResource()->load($value, $field);
        // print("the data is ");
        // print_r($this->_data);

        // echo "<pre>";// print_r($this);

        // echo "</pre>";
        $this->_afterLoad();
        return $this;
    }
    public function getCollection()
    {
        $collection = new $this->_collectionClassName;
        $collection->setResource($this->getResource())->setModel(
            $this
        )->select();
        return $collection;
    }
    public function delete()
    {
        $this->getResource()->delete($this);
        return $this;
    }
    public function save()
    {
        $this->getResource()->save($this);
        // $this->_afterSave();
        return $this;
    }
    protected function _afterLoad()
    {
        // return $this;
    }
    protected function _afterSave()
    {
       
    }
}
