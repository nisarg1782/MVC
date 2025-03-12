<?php
class Checkout_Controller_Address
{
    public function indexAction()
    {
        $layout=Mage::getBlock("core/layout");
        $address_index=$layout->createBlock("checkout/address_index")->setTemplate("checkout/address/index.phtml");
        $layout->getChild("content")->addChild("address_index",$address_index);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $cartid=Mage::getSingleton("checkout/session")->getCart()->getCartId();
        $request=Mage::getModel("core/request");
        $billing_data=$request->getparam("billing");
        $shipping_data=$request->getParam("shipping");
        $email=$request->getParam("cart");
      
        $cart_address=Mage::getModel("checkout/cart_address");
        $billing_data["address_type"]="Billing";
        $billing_data["cart_id"]=$cartid;
        $cart_address->setData($billing_data);
        $cart_address->save();

        // $cart_address=Mage::getModel("checkout/cart_address");
        $shipping_data["address_type"]="Shipping";
        $shipping_data["cart_id"]=$cartid;
        $cart_address->setData($shipping_data);
        $cart_address->save();
        // mage::log($cartid);
        $cart=Mage::getSingleton("checkout/session")->getCart();
        $cart->setEmail($email["email"])->save();
        $layout=Mage::getBlock("core/layout");
        $url=$layout->getUrl("checkout/shipping/index");
        header("location:$url");
    }
    
}
?>