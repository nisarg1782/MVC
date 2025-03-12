<?php
ob_start();
// session_start();
class Checkout_Controller_Cart
{
    public $productdata = [];
    public function indexAction()
    {


        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_index')
            ->setTemplate('checkout/cart/index.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function updateAction()
    {
        $request=Mage::getModel("core/request");
        $item_id=$request->getQuery("id");
        $quantity=$request->getQuery("quantity");
        // echo '<pre>';
        // print_r($item_id);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($quantity);
        // echo '</pre>';
        $cart=Mage::getSingleton("checkout/session")->getCart();
        $cart->updateItem($item_id,$quantity);
        $cart->save();
        $layout = Mage::getBlock('core/layout');
        $url=$layout->getUrl("*/*/index");
        header("location:$url");
      
    }
    public function addAction()
    {

        $product_id = 0;
        $quantity = 0;
        $request = Mage::getModel("core/request");
        $data = $request->getParam("cart");
        $product_id = $data["productId"];
        $quantity = $data["quantity"];
        $quantity = intval($quantity);
        $product_id = intval($product_id);
        // var_dump($quantity);
        // var_dump($product_id);
        $cart_model = Mage::getSingleton("checkout/session")->getCart()->addProduct(
            $product_id,
            $quantity
        )->save();
        // $cart_item_data = $cart_model->getItemCollection()->getData();
        // foreach ($cart_item_data as $cartdata) {
        //     $this->productdata[] = $cartdata->getProduct();
        // }
        $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Checkout/Cart/Index");
        // print_r($url);
        header("location:$url");
    }
    public function removeAction()
    {
        $request = Mage::getModel("core/request");
        $id = $request->getQuery("id");
        // print_r($id);
        $cart = Mage::getSingleton("checkout/session")->getCart();
        $cart->removeItem($id);
        $cart->setCartId($cart->getCartId());
        $cart->save();
        $layout = Mage::getBlock('core/layout');
        $url = $layout->getUrl("Checkout/Cart/Index");
        header("location:$url");
    }
    public function testAction()
    {
     $cart_address=Mage::getModel("checkout/cart_address")->getCollection()->getData();
     echo '<pre>';
     print_r($cart_address);
     echo '</pre>';
    }
    public function applyCouponAction()
    {
        $total=0;
        $request=Mage::getModel("core/request");
        $coupon=$request->getParam("coupon");
        $cart=Mage::getSingleton("checkout/session")->getCart()->getItemCollection();
       foreach($cart->getData() as $_cart)
       {
        $total+=$_cart->getSubTotal();
       }
       Mage::getModel("checkout/coupon")->calculateDiscount($total,$coupon);
       $layout = Mage::getBlock('core/layout');
       $url = $layout->getUrl("Checkout/Cart/Index");
       header("location:$url");
    }
    
}
