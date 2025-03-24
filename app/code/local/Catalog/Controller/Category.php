<?php
class Catalog_Controller_Category extends Core_Controller_Front_Action
{

    public function listAction()
    {
        //print(__CLASS__." <br>" . __FUNCTION__);
        $layout = $this->getLayout();
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
        $layout = $this->getLayout();
        $new = $layout->createBlock('catalog/category_new')
            ->setTemplate('catalog/category/new.phtml');
        //    print_r($view);
        $layout->getChild('content')->addChild('new', $new);
        //print_r($layout);
        $layout->toHtml();
    }
    public function saveAction()
    {
        $request = $this->getRequest();
        $product = Mage::getModel('catalog/category');
        $layout = $this->getLayout();
        // echo "<pre>";
        $data = $request->getParam("catalog_category");
        $product->setData($data);
        $product->save();
        print("data saved");
        $url = $layout->getUrl("*/*/list");
        header("Location:" . $url);
    }
    public function deleteAction()
    {
        $request = $this->getRequest();
        $product = Mage::getModel('catalog/category');
        $layout = $this->getLayout();
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
