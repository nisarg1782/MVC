<?php
class Catalog_Controller_Product
{

    public function viewAction()
    {
        $layout = Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view')
            ->setTemplate('catalog/product/view.phtml');

        $layout->getChild('content')->addChild('view', $view);

        $layout->toHtml();
    }
    public function listAction()
    {
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/product_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
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
}
