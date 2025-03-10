<?php
class Checkout_Block_Cart_Index extends Core_Block_Template
{
    public function getCartData()
    {
        $session = Mage::getModel("core/session");
        $data = $session->get("cart");
        return $data;
    }
}
