<?php
class Admin_Controller_Order
{
    public function listAction()
    {
        $layout=Mage::getBlock("core/layout");
        $list=$layout->createBlock("admin/order_list")
                        ->setTemplate("admin/order/list.phtml");
        $layout->getChild("content")->addChild("list_order",$list);
        $layout->toHtml();
    }
    public function viewAction()
    {
        $layout=Mage::getBlock("core/layout");
        $view_order=$layout->createBlock("admin/order_view")
                    ->setTemplate("admin/order/view.phtml");
        $layout->getChild("content")->addChild("view_order",$view_order);
        $layout->toHtml();
    }
}
?>