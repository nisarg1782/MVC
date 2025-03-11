<?php
ob_start();
// session_start();
class Checkout_Controller_Cart
{
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
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_update')
            ->setTemplate('checkout/cart/update.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartupdate', $cartview);

        $layout->toHtml();
    }
    public function addAction()
    {
        $product_id=0;
        $quantity=0;
       $request=Mage::getModel("core/request");
       $data=$request->getParam("cart");
       
       $product_id=$data["productId"];
       $quantity=$data["quantity"];
       $cart_model=Mage::getSingleton("checkout/session")->getCart();
       $cart_model->addProduct($product_id,$quantity);

    
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_add')
                       ->setTemplate('checkout/cart/add.phtml');
        // $request=$layout->getRequest();
                    //    print_r($view);
                
        $layout->getChild('content')->addChild('cartadd',$cartview);

        $layout->toHtml();
    }
    public function removeAction()
    {
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_remove')
            ->setTemplate('checkout/cart/remove.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartremove', $cartview);

        $layout->toHtml();
    }
    public function testAction()
    {
        $cart=Mage::getModel("checkout/cart")->getCollection()->getData();
        print_r($cart);

        $cart_item=Mage::getModel("checkout/cart_item")->getCollection()->getData();
        print_r($cart_item);
    }
    public function addProductAction()
    {
        
    }
}
