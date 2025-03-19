<?php
class Checkout_Block_Address_Index extends Core_Block_Template
{
    public function getAddress()
    {
        $cartid=Mage::getModel("checkout/session")->getCart()->getCartId();
        // Mage::log($cartid);
        $data=Mage::getModel("checkout/cart_address")->getCollection()->addFieldToFilter(
            "cart_id",["="=>$cartid]
        )->getData();
        if(!empty($data))
        {
            return $data;
        }
        else{
            $data=null;

        }
        return $data;
        // mage::log($data);
    }
  
}
?>