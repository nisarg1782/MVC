<?php
class Catalog_Controller_Category
{

    public function listAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list')
            ->setTemplate('catalog/category/list.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('list', $list);
        //print_r($layout);
        $layout->toHtml();
    }

    public function newAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = Mage::getBlock('core/layout');
        $new = $layout->createBlock('catalog/category_new')
            ->setTemplate('catalog/category/new.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('new', $new);
        //print_r($layout);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = Mage::getModel('core/request');
        $product = Mage::getModel('catalog/category');
        $layout = Mage::getBlock('core/layout');
        echo "<pre>";
        $data = $request->getParam("catalog_category");
        $product->setData($data);
        $product->save();
        print("data saved");
        $url = $layout->getUrl("*/*/list");
        header("Location:" . $url);
    }
    public function deleteAction()
    {
        $request = Mage::getModel("core/request");
        $product = Mage::getModel('catalog/category');
        $layout = Mage::getBlock("core/layout");
        $new = $layout->createBlock('catalog/category_delete');
        $id = $request->getQuery("id");
        //print("the id is ".$id);
        //$request->delete($id);
        $prod_Deldata = $product->getResource()->load($id);
        print_r($prod_Deldata);
        $product->setData($id);
        $product->delete();

        $url = $layout->getUrl("*/*/list");
        header("Location:" . $url);
    }
}
