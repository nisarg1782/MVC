<?php
class Checkout_Model_Cart_Item extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Checkout_Model_Resource_Cart_Item";
        $this->_collectionClassName="Checkout_Model_Resource_Cart_Item_Collection";
    }
}
?>