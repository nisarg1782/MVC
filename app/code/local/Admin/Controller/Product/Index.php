<?php
ob_start();
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{
   //protected $_product = [];
   public function newAction()
   {
      // $request = Mage::getModel("core/request");
      $cartview = $this->getLayout()
         ->createBlock('Admin/Product_New')
         ->setTemplate('admin/product/new.phtml');
      $this->getLayout()
         ->getChild('content')
         ->addChild('cartindex', $cartview);
      $this->getLayout()
         ->toHtml();
   }
   public function listAction()
   {
      //print(__CLASS__." <br>" . __FUNCTION__);
      $layout = $this->getLayout();
      $cartview = $layout->createBlock('Admin/Product_List')
         ->setTemplate('admin/product/list.phtml');
      // $toolbar_block=$layout->createBlock("Admin/grid_toolbar")
      //    ->setTemplate("admin/grid/toolbar.phtml");

      //    print_r($view);
      $layout->getChild('content')->addChild('list_prod', $cartview);

      $layout->getChild("head")->addCss("css/admin/list.css");
      //print_r($layout);
      $layout->toHtml();
   }
   public function saveAction()
   {
      $data = [];
      $attr_data = [];

      $request = Mage::getModel('core/request');
      $main_img = $request->getParam("main_image");
      $product = Mage::getModel('catalog/product');
      $product_gallrey = Mage::getModel("catalog/gallrey");
      $product_attribute = Mage::getModel("catalog/attribute");
      $layout = $this->getLayout();

      $product_data = $request->getParam("catalog_product");
      $attribute_data = $request->getParam("catalog_product_attribute");
      
      $name = substr($product_data["name"], 0, 3);
      $sku = $product_data["color"] . $product_data["category_id"] . $name . "abcdokyhyhyh";
      $product_data["sku"] = $sku;
      $product->setData($product_data);
      // print_r($product);

      $product_data_model = $product->save();

      $url = $layout->getUrl("*/*/list");
      header("Location:" . $url);

      // print($product_gallrey->getProductId());
   }
   public function testAction()
   {
      $request = Mage::getModel("core/request");
      $product = Mage::getModel('catalog/product');
      $layout = $this->getLayout();
  
      $request_single = Mage::getSingleton("catalog/product");
      $request_single->name = "abcdefg";
      print_r($request_single);

      $request_single2 = Mage::getSingleton("catalog/product")->load(65);

      // print_r($request_single2);
   }
   public function deleteAction()
   {
      $request = Mage::getModel("core/request");
      $product = Mage::getModel('catalog/product');
      $layout = $this->getLayout();
      $id = $request->getQuery("id");
 
      $prod_Deldata = $product->getResource()->load($id);

      
      $filepath = "C:/xampp/htdocs/MVC/Media/" . $product->getResource()->getTablename() . "/" . $prod_Deldata["image"];
      print($filepath);
      unlink($filepath);
      $product->setData($id);
      $product->delete();
      $url = $layout->getUrl("*/*/list");
      header("Location:" . $url);
   }

   public function exportAction()
   {
      $product_data = Mage::getModel("catalog/product")
         ->getCollection()
         ->getData();
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename="export_products.csv"');


      $output = fopen('php://output', 'w');
      foreach ($product_data as $product) {
         $productData = Mage::getModel("catalog/product")
            ->load($product->getProductId())
            ->getData();
         unset($productData["files"]);
         $allProductData[] = $productData;
      }
      // Write product data to CSV
      fputcsv($output, array_keys($allProductData[0]));

      // Write product data to CSV
      foreach ($allProductData as $data) {
         fputcsv($output, $data);
      }


      // Close output stream
      fclose($output);
      exit; // Stop further execution
   }
}
