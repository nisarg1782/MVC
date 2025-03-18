<?php
class Admin_Controller_Order
{
    public function listAction()
    {
        $layout = Mage::getBlock("core/layout");
        $list = $layout->createBlock("admin/order_list")
            ->setTemplate("admin/order/list.phtml");
        $layout->getChild("content")->addChild("list_order", $list);
        $layout->toHtml();
    }
    public function viewAction()
    {

        $layout = Mage::getBlock("core/layout");
        $order_id = Mage::getModel("core/request")
            ->getQuery("order_id");
        // print($order_id);

        $order = Mage::getModel("sales/order")
            ->load($order_id);
        $view_order = $layout->createBlock("admin/order_view")
            ->setTemplate("admin/order/view.phtml");

        $view_order->setOrder($order);
        $order_block = $layout->createBlock("admin/order_order");
        $product_block = $layout->createBlock("admin/order_product");
        $address_block = $layout->createBlock("admin/order_address");

        $order_block->setOrderBlock($view_order);
        $address_block->setOrderBlock($view_order);
        $product_block->setOrderBlock($view_order);

        // echo '<pre>';
        // print_r($view_order->getOrder());
        // echo '</pre>';
        // die;
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
