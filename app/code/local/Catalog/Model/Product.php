<?php
class Catalog_Model_Product extends Core_Model_Abstract
{
    
    public function init()
    {
        $this->_resourceClassName = "Catalog_Model_Resource_Product";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Collection";
    }
    public $status = [
        '0' => "disabled",
        '1' => "enabled"
    ];
    public function getProductStatusText()
    {
        // echo $this->getProductStatus();
        
        return isset($this->status[$this->getProductStatus()])? $this->status[$this->getProductStatus()]:"NA";
    }
   
}