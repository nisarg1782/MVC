<?php
class Catalog_Controller_Product extends Core_Controller_Front_Action
{
    public function viewAction()
    {
        $layout = $this->getLayout();
        $view = $layout->createBlock('catalog/product_view')
            ->setTemplate('catalog/product/view.phtml');

        $layout->getChild('content')->addChild('view', $view);

        $layout->toHtml();
    }
    public function listAction()
    {

        $layout = $this->getLayout();
        $request = $this->getRequest();
        $list = $layout->createBlock('catalog/product_list');
        $layout->getChild('content')->addChild('list', $list);
        if ($request->isAjax()) {
            // print("in if");
            $layout->getChild("content")
                ->getChild("list")
                ->removeChild("filter");

            $layout->getChild("content")
                ->getChild("list")
                ->getChild("products")
                ->removeChild("toolbar");
            // $layout->getChild("content")->getChild("list")->removeChild("products");
            $layout->removeChild("footer");
            $layout->removeChild("header");
            // $message_block = $layout->createBlock("core/message_message")
                // ->addMessage("warning", "dont you dare");
            // echo '<pre>';
            // print_r($_SESSION);
            // echo '</pre>';
        } else {

            // print("no in ajax");
            // error_log("Not an AJAX request.");
        }

        $layout->toHtml();
        // $request = Mage::getSingleton("core/request");
        // $tmp_get = $request->getQuery();
        // if (empty($tmp_get)) {
        //     $layout = $this->getLayout();
        //     $list = $layout->createBlock('catalog/product_list');
        //     $layout->getChild('content')->addChild('list', $list);
        //     $layout->toHtml();
        // } else {
        //     header("Content-Type:application/json");
        //     $productData = Mage::getBlock('catalog/product_list')
        //                 ->productData()
        //                 ;
        //     $data=[];
        //     foreach($productData as $row){
        //         $data[]=$row->getData();
        //     }
        //     echo json_encode($data);
        // }
    }

    // public function testAction()
    // {

    //     $model = Mage::getModel("catalog/product")->getCollection()
    //         ->innerJoin("catlog_category", "catlog_category.category_id = catlog_product.category_id", ["category_name" => "name"]);
    //        // ->crossJoin("catlog_category","catlog_category.category_id=catlog_product.category_id" ,["category_name" => "name"]);
    //         // ->leftJoin("catlog_category","catlog_category.category_id=catlog_product.category_id" ,["category_name" => "name"]);
    //         // ->rightJoin("catlog_category","catlog_category.category_id=catlog_product.category_id" ,["category_name" => "name"]);
    //         // ->fullOuterJoin("catlog_category","catlog_category.category_id = catlog_product.category_id" ,["category_name" => "name"]);
    //         // prnding : ->selfJoin("catlog_product" ,["category_name" => "name"]);

    //         // ->Limit(1);
    //           //->orderBy(["name"=>"ASC","price"=>"DESC"]);
    //         // ->having("product_id",["<"=>66])

    //         // ->having("name",["LIKE"=>"h%"])
    //         // ->GroupBy(["name","price"]);




    //     //print_r($model);
    //     // //die();
    //     $data = $model->getdata();
    //     echo "<pre>";
    //     print_r($data);




    //     // $id = Core_Model_Request::getQuery("id");
    //     // $product = Mage::getModel("catalog/product");
    //     // $data = $product->delete($id);

    //     // if ($data) {
    //     //     print("data deleted succesfully");
    //     // } 
    //     // else 
    //     // {
    //     //     print("not deleted ");
    //     // }
    //     // $product=Mage::getModel("catalog/product")->load(34);
    //     // echo "<pre>";
    //     // // print_r($product);
    //     // $product->setName("abc'd");
    //     // $product->setPrice(780);
    //     // $product->save();
    //     // echo "<pre>";
    //     //print_r($product);
    // }
    public function testAction()
    {

        $message_block = $this->getLayout()->createBlock("core/message_message")
            ->addMessage("warning", "dont you dare")
            ->addMessage("error","no");
           
        // echo '<pre>';
        print_r($_SESSION);
        // echo '</pre>';
        $this->getLayout()->toHtml();
    }
    public function test2Action()
    {

        // $message_block = $this->getLayout()->createBlock("core/message_message")
        //     ->addMessage("warning", "dont you dare")
        //     ->addMessage("error","no");
           
        // echo '<pre>';
        print_r($_SESSION);
        // echo '</pre>';
        $this->getLayout()->toHtml();
    }
    public function test33Action()
    {

        // $message_block = $this->getLayout()->createBlock("core/message_message")
        //     ->addMessage("warning", "dont you dare")
        //     ->addMessage("error","no");
           
        // echo '<pre>';
        print_r($_SESSION);
        // echo '</pre>';
        $this->getLayout()->toHtml();
    }
}
