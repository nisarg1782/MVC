<?php
class Checkout_Block_Shipping_Index extends Core_Block_Layout
{
    public function getAllprovider()
    {
        $data=Mage::getModel("checkout/shipping")->getAllShippingProvider();
        return $data;
    }
}
?>