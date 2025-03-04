<?php
class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
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
      $layout = Mage::getBlock('core/layout');
      
      $product_data = $request->getParam("catalog_product");
      $attribute_data = $request->getParam("catalog_product_attribute");
      echo "<pre>";
      print_r($product_data);
        // die();
        $name = substr($product_data["name"], 0, 3);
        $sku = $product_data["color"] . $product_data["category_id"] . $name;
        $product_data["sku"] = $sku;
      $product->setData($product_data);
      print_r($product);
     
      $product->save();
     
      
      die;


      $image_data = $_FILES["catalog_media_gallery"];
      // print_r($_FILES);
    
      $product->setData($product_data);
      //print_r($request->getQuery("catlog_product"));

      $product_data_model = $product->save();

      // $tablename = $product_attribute->getResource()->getTablename();

      // for storing attributes in attribute tables 
      $tmp = 0;
      foreach ($attribute_data as $key => $value) {
         $single_attribute = $product_attribute
            ->load($key, "name");

         // $data1 = $single_attribute->getData();


         // Ensure data exists before accessing it
         if (isset($product_data["product_id"]) && $product_data["product_id"]) {
            $attribute = Mage::getModel("catalog/product_attribute")->getCollection()
               ->addFieldToFilter("product_id", ["=" => $product_data["product_id"]]);
            $att_data = $attribute->getData();

            if (!empty($att_data) && isset($att_data[$tmp])) { // Ensure index exists before using it
               $attr_data["value_id"] = $att_data[$tmp]->getValueId();
               $tmp++;
            } else {
               error_log("Warning: No attribute data found for product_id " . $product_data["product_id"]);
            }
         }

         $attr_data["product_id"] = $product_data_model->getProductId();
         $attr_data["attribute_id"] = $single_attribute->getAttributeId();
         $attr_data["value"] = $value;

         $attribute_model = Mage::getModel("catalog/product_attribute");


         $attribute_model->setData($attr_data);
         $attribute_model->save();
      }


      // for storing Images in media gallery
      $tablename = $product_gallrey->getResource()->getTablename();
      $count_images = count($_FILES[$tablename]["name"]["images"]);
      // print_r($_FILES["catalog_media_gallrey"]["name"]["images"]);
      // print(count($_FILES["catalog_media_gallrey"]["name"]["images"]));
      // if ($_FILES[$tablename]["name"]["main_image"] && $_FILES[$tablename]["error"]["main_image"] == 0) {

      //    $base_dir = Mage::getBaseDir();
      //    $upload_dir = $base_dir . DS . "media" . DS .  $tablename;

      //    if (!file_exists($upload_dir)) {
      //       mkdir($upload_dir, 0755, true);
      //    }

      //    $tmp_name = $_FILES[$tablename]["tmp_name"]["main_image"];
      //    $filename = basename($_FILES[$tablename]["name"]["main_image"]);
      //    $upload_path = $upload_dir . DS . $filename;

      //    if (move_uploaded_file($tmp_name, $upload_path)) {
      //       // Mage::log("File uploaded: " . $upload_path, null, 'custom_upload.log', true);
      //       $data["main_image"] = $filename;
      //       $data["type"] = "image";
      //       $data["product_id"] = $product_data_model->getProductId();
      //       $product_gallrey->setData($data);
      //       $product_gallrey->save();
      //    }
      // } 


      for ($i = 0; $i < $count_images; $i++) {
         if ($_FILES[$tablename]["name"]["images"][$i] && $_FILES[$tablename]["error"]["images"][$i] == 0) {

            $base_dir = Mage::getBaseDir();
            $upload_dir = $base_dir . DS . "media" . DS .  $tablename;

            if (!file_exists($upload_dir)) {
               mkdir($upload_dir, 0755, true);
            }
            if (basename($_FILES[$tablename]["name"]["images"][$i] == $main_img)) {
               print("in if");
               $data["default_file_path"] = 1;
            } else {
               print("in else");
               $data["default_file_path"] = 0;
            }

            $tmp_name = $_FILES[$tablename]["tmp_name"]["images"][$i];
            $filename = basename($_FILES[$tablename]["name"]["images"][$i]);
            $upload_path = $upload_dir . DS . $filename;
            // print($filename);
            // print("<br>");
            // print($main_img);
            // die;


            if (move_uploaded_file($tmp_name, $upload_path)) {

               // Mage::log("File uploaded: " . $upload_path, null, 'custom_upload.log', true);
               $data["file_path"] = $filename;
               $data["type"] = "image";
               $data["product_id"] = $product_data_model->getProductId();
               $product_gallrey->setData($data);
               $product_gallrey->save();
            } else {
            }
         } else {
         }
      }

      $url = $layout->getUrl("*/*/list");
      header("Location:" . $url);

      // print($product_gallrey->getProductId());
   }
   public function testAction()
   {
      $request = Mage::getModel("core/request");
      $product = Mage::getModel('catalog/product');
      $layout = Mage::getBlock("core/layout");
      // $id = $request->getQuery("id");
      //print("the id is ".$id);
      //$request->delete($id);
      echo "<pre>";
      // $prod_Deldata = $product->getResource()->load(65);
      // print_r($prod_Deldata);

      // $request2=Mage::getModel("catalog/product");
      // print_r($request2);
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
   }
}
