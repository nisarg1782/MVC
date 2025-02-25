<?php
class Admin_Model_Customer extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Admin_Model_Resource_Customer";
        $this->_collectionClassName="Admin_Model_Resource_Customer_Collection";
    }
}
?>