<?php
class Checkout_Controller_Shipping extends Core_Controller_Front_Action
{
    public function indexAction()
    {
        $layout=$this->getLayout();
        $shipping_index=$layout->createBlock("checkout/shipping_index")
            ->setTemplate("checkout/shipping/index.phtml");
        $layout->getChild("content")->addChild("shipping_index",$shipping_index);
        $layout->toHtml();

    }
    public function saveAction()
    {
        $request=$this->getRequest();
        $provider_name=$request->getParam("shipping_provider");
        $payment_type=$request->getParam("payment_method");
        $charge=Mage::getModel("checkout/shipping")
            ->calculateCharges($provider_name);
        
        $cart=Mage::getSingleton("checkout/session")->getCart();
        $cart->setCharge($charge["charge"])
        ->setProviderName($charge["name"])
        ->setPaymentMethod($payment_type)->
        save();
    }
}
?>