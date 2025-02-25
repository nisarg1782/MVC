<?php
class Admin_Model_Product extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Admin_Model_Resource_Product";
        $this->_collectionClassName="Admin_Model_Resource_Product_Collection";
    }
}
?>