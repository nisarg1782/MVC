<?php
class Checkout_Model_Resource_Cart_Address extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init("cart_address","cart_address_id");
    }
}
?>