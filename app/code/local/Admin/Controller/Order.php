<?php
class Admin_Controller_Order extends Core_Controller_Admin_Action
{
    public function listAction()
    {
        $layout = $this->getLayout();
        $list = $layout->createBlock("admin/sales_order_list");
            // ->setTemplate("admin/sales/order/list.phtml");
        $layout->getChild("content")->addChild("list_order", $list);
        $layout->toHtml();
    }
    public function viewAction()
    {

        $layout = $this->getLayout();
        $order_id = Mage::getModel("core/request")
            ->getQuery("order_id");
        // print($order_id);

        $order = Mage::getModel("sales/order")
            ->load($order_id);
        $view_order = $layout->createBlock("admin/sales_order_view")
            ->setTemplate("admin/sales/order/view.phtml");

        $view_order->setOrder($order);
        $order_block = $layout->createBlock("admin/sales_order_order");
        $product_block = $layout->createBlock("admin/sales_order_product");
        $address_block = $layout->createBlock("admin/sales_order_address");
       

     

        
        $layout->getChild("content")
                ->addChild("view_order", $view_order);
        $layout->getChild("content")
                ->getChild("view_order")
                ->addChild("order", $order_block);
        $layout->getChild("content")
                ->getChild("view_order")
                ->addChild("item", $product_block);
        $layout->getChild("content")
                ->getChild("view_order")
                ->addChild("address", $address_block);
        $layout->toHtml();

        
    }
}
