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
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_update')
            ->setTemplate('checkout/cart/update.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartupdate', $cartview);

        $layout->toHtml();
    }
    public function addAction()
    {
        // $productdata=[];
        $product_id = 0;
        $quantity = 0;
        $request = Mage::getModel("core/request");
        $data = $request->getParam("cart");
        $product_id = $data["productId"];
        $quantity = $data["quantity"];
        $quantity = intval($quantity);
        $product_id = intval($product_id);
        var_dump($quantity);
        var_dump($product_id);
        $cart_model = Mage::getSingleton("checkout/session")->getCart()->addProduct($product_id,$quantity
    )->save();
        $cart_item_data = $cart_model->getItemCollection()->getData();
        foreach ($cart_item_data as $cartdata) {
            $this->productdata[] = $cartdata->getProduct();
        }
        $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Checkout/Cart/Index");
        print_r($url);
        header("location:$url");
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
    public function testAction() {}
    public function addProductAction() {}
}
