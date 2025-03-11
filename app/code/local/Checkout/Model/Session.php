<?php
class Checkout_Model_Session extends Core_Model_Session
{
    public function getCart()
    {
        
        $cart_id = $this->get("cart_id");
        var_dump($cart_id);
        // print_r($_SESSION);
        // session_unset();
        // session_destroy();
        // echo "cart in session";
        // var_dump($cart_id);
        // print_r("<br>");
        // die;
        if ($cart_id=="") {
            $cart_model = Mage::getModel("checkout/cart")
                ->setCustomerId(0)
            ->setProductId(0)
                ->save();
                echo "<pre>";
                print_r($cart_model);
              
                
            $this->set("cart_id",$cart_model->getCartId());
            return $cart_model;
        } else {
            $cart_model=Mage::getModel("checkout/cart")->load($cart_id);
            return $cart_model;

        }
    }
}
