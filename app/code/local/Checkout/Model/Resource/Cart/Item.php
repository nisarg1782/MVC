<?php
class Checkout_Model_Resource_Cart_Item extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init("cart_item","item_id");
    }
}
?>
<!-- Catalog_Model_Resource_Product_Attribute -->