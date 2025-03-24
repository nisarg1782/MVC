<?php
class Checkout_Controller_Address extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout=$this->getLayout();
        $address_index=$layout->createBlock("checkout/address_index")
            ->setTemplate("checkout/address/index.phtml");
        $layout->getChild("content")->addChild("address_index",$address_index);
        $layout->getChild("head")->addJs("js/page/form.js");
        $layout->toHtml();
    }
    public function saveAction()
    {
        $cartid=Mage::getSingleton("checkout/session")
            ->getCart()
            ->getCartId();
        $request=$this->getRequest();
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
        $layout=$this->getLayout();
        $this->redirect("checkout/shipping/index");
        // header("location:$url");
    }
    
}
?>