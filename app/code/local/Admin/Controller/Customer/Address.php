<?php
class Admin_Controller_Customer_Address extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = $this->getLayout();
        $cartview = $layout->createBlock('Admin/Address_New')
            ->setTemplate('admin/address/new.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function listAction()
    {
        $layout = $this->getLayout();
        $cartview = $layout->createBlock('Admin/Address_List')
            ->setTemplate('admin/address/list.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $layout = $this->getLayout();
        $cartview = $layout->createBlock('Admin/Address_Save')
            ->setTemplate('admin/address/save.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
    public function deleteAction()
    {
        $layout = $this->getLayout();
        $cartview = $layout->createBlock('Admin/Address_Delete')
            ->setTemplate('admin/address/delete.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('cartindex', $cartview);
        //print_r($layout);
        $layout->toHtml();
    }
}

?>