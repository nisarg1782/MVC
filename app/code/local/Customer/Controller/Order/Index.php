<?php
class Customer_Controller_Order_Index extends Core_Controller_Front_Action
{
    public function viewAction()
    {
        $order_id=$this->getRequest()->getQuery("order_id");
        $order=Mage::getModel("sales/order")->load($order_id);
        
        $layout=$this->getLayout();
        $view_order=$layout->createBlock("customer/account_order_view")
                ->setTemplate("customer/order/view.phtml");
        $layout->getChild("content")->addChild("view_order",$view_order);
        $view_order->setOrder($order);

        $customer_order_item=$layout->createBlock("customer/account_order_item");
        $layout->getChild("content")
        ->getChild("view_order")
        ->addChild("customer_order_item",$customer_order_item);
        // $customer_order_item->setOrderBlock($view_order);

        $customer_order_address=$layout->createBlock("customer/account_order_address");
        $layout->getChild("content")
        ->getChild("view_order")
        ->addChild("customer_order_address",$customer_order_address);
        // $customer_order_address->setOrderBlock($view_order);

        $customer_order=$layout->createBlock("customer/account_order_order");
        $layout->getChild("content")
        ->getChild("view_order")
        ->addChild("customer_order",$customer_order);
        // $customer_order->setOrderBlock($view_order);

        $layout->toHtml();
    }
}
?>