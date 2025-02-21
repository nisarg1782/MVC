<?php
class Checkout_Controller_Cart
{
    public function indexAction()
    {
       
         //print(__CLASS__." <br>" . __FUNCTION__);
         $layout = Mage::getBlock('core/layout');
         $cartview = $layout->createBlock('checkout/cart_index')
                        ->setTemplate('checkout/cart/index.phtml');
                     //    print_r($view);
         $layout->getChild('content')->addChild('cartindex',$cartview);
         //print_r($layout);
         $layout->toHtml();
         
    }
    public function updateAction()
    {
        $layout = Mage::getBlock('core/layout');
         $cartview = $layout->createBlock('checkout/cart_update')
                        ->setTemplate('checkout/cart/update.phtml');
                     //    print_r($view);
         $layout->getChild('content')->addChild('cartupdate',$cartview);
         
         $layout->toHtml();
    }
    public function addAction()
    {
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('checkout/cart_add')
                       ->setTemplate('checkout/cart/add.phtml');
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
        $layout->getChild('content')->addChild('cartremove',$cartview);
        
        $layout->toHtml();
    }
}

?>