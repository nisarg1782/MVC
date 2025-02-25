<?php
class Admin_Model_Address extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Admin_Model_Resource_Address";
        $this->_collectionClassName="Admin_Model_Resource_Address_Collection";
    }
}
?>