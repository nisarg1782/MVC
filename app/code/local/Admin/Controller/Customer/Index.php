<?php
class Admin_Controller_Customer_Index
{
    public function newAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('Admin/Customer_New')
            ->setTemplate('admin/customer/new.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function listAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('Admin/Customer_List')
            ->setTemplate('admin/customer/list.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function saveAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $cartview = $layout->createBlock('Admin/Customer_Save')
            ->setTemplate('admin/customer/save.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function deleteAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
       $layout = Mage::getBlock('core/layout');
       $cartview = $layout->createBlock('Admin/Customer_Delete')
                      ->setTemplate('admin/customer/delete.phtml');
                   //    print_r($view);
       $layout->getChild('content')->addChild('cartindex',$cartview);
       //print_r($layout);
       $layout->toHtml();
    }
    
}
