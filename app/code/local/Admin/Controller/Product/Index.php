<?php
class Admin_Controller_Product_Index
{
   //protected $_product = [];
   public function newAction()
   {
      $request = Mage::getModel("core/request");
      // $id=$request->getQuery("id");
      // print("the id is".$id);

      $layout = Mage::getBlock('core/layout');
      $cartview = $layout->createBlock('Admin/Product_New')
         ->setTemplate('admin/product/new.phtml');
      $layout->getChild('content')->addChild('cartindex', $cartview);
      $layout->toHtml();


      //$product=Mage::getModel("catalog/product")->load(34);
      //   echo "<pre>";
      //   // print_r($product);
      //   $product->setName("abc'd");
      //   $product->setPrice(780);
      //   $product->save();
      //   echo "<pre>"
   }
   public function listAction()
   {
      //print(__CLASS__." <br>" . __FUNCTION__);
      $layout = Mage::getBlock('core/layout');
      $cartview = $layout->createBlock('Admin/Product_List')
         ->setTemplate('admin/product/list.phtml');
      //    print_r($view);
      $layout->getChild('content')->addChild('cartindex', $cartview);
      //print_r($layout);
      $layout->toHtml();
   }
   public function saveAction()
   {
      $request = Mage::getModel('core/request');
      $product = Mage::getModel('catalog/product');
      $layout = Mage::getBlock('core/layout');
      echo "<pre>";
      $data = $request->getParam("catlog_product");
      $tablename = $product->getResource()->getTablename();

      if ($_FILES[$tablename]["name"]["image"] && $_FILES[$tablename]["error"]["image"] == 0) {


         $base_dir = Mage::getBaseDir();
         print_r($base_dir);
         print("<br>");

         $upload_dir = $base_dir . "Media/" . $tablename;
         if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
         }
         $filename = basename($_FILES[$tablename]["name"]["image"]);
         print("the file name is " . $filename);
         $upload_dir .= "/" . $filename;
         print($upload_dir);

         if (move_uploaded_file($_FILES[$tablename]["tmp_name"]["image"], $upload_dir)) {
            $data["image"] = $filename;
         }
      }
      if ($data["product_status"] == "0") {
         $data["product_status"] = 0;
      } else {
         $data["product_status"] = 1;
      }
      //print_r($request->getParam('catlog_product'));
      $product->setData($data);
      //print_r($request->getQuery("catlog_product"));


      $product->save();
      //print_r($product);
      $url = $layout->getUrl("*/*/list");
      header("Location:" . $url);
      //   die();

      // //print(__CLASS__." <br>" . __FUNCTION__);
      // $layout = Mage::getBlock('core/layout');
      // $cartview = $layout->createBlock('Admin/Product_Save')
      //    ->setTemplate('admin/product/save.phtml');
      // //    print_r($view);
      // $layout->getChild('content')->addChild('cartindex', $cartview);
      // //print_r($layout);
      // $layout->toHtml();
   }
   public function deleteAction()
   {
      $request = Mage::getModel("core/request");
      $product = Mage::getModel('catalog/product');
      $layout = Mage::getBlock("core/layout");
      $id = $request->getQuery("id");
      //print("the id is ".$id);
      //$request->delete($id);
      $prod_Deldata = $product->getResource()->load($id);

      //$filename=$prod_Deldata["image"];
      $filepath = "C:/xampp/htdocs/MVC/Media/" . $product->getResource()->getTablename() . "/" . $prod_Deldata["image"];
      print($filepath);
      unlink($filepath);
      $product->setData($id);
      $product->delete();
      $url = $layout->getUrl("*/*/list");
      header("Location:" . $url);

      //print(__CLASS__." <br>" . __FUNCTION__);
      //$layout = Mage::getBlock('core/layout');


      // $cartview = $layout->createBlock('Admin/Product_Delete')
      //    ->setTemplate('admin/product/delete.phtml');
      // //    print_r($view);
      // $layout->getChild('content')->addChild('cartindex', $cartview);
      // //print_r($layout);
      // $layout->toHtml();
   }
   //  public function testAction()
   //  {
   //      print_r ($product);
   //      print("<br>");
   //      echo $product->getCategoryId();

   //  }
  
}
