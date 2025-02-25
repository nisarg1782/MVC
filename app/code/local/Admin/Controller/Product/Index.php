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
      $product = Mage::getModel('catalog/product');
      $product_gallrey = Mage::getModel("catalog/gallrey");
      $product_attribute = Mage::getModel("catalog/attribute");
      $layout = Mage::getBlock('core/layout');
      echo "<pre>";
      $product_data = $request->getParam("catalog_product");
      $attribute_data = $request->getParam("catalog_product_attribute");
      // print_r($attribute_data);



      $image_data = $_FILES["catalog_media_gallery"];
      // print_r($_FILES);
      // die();

      $name = substr($product_data["name"], 0, 3);
      $sku = $attribute_data["color"] . $product_data["category_id"] . $name;
      $product_data["sku"] = $sku;
      $product->setData($product_data);
      //print_r($request->getQuery("catlog_product"));

      $product_data_model = $product->save();
      $tablename = $product_attribute->getResource()->getTablename();
      foreach ($attribute_data as $key => $value) {
         $single_attribute = $product_attribute->getCollection()->addFieldToFilter("name", ["=" => $key]);
         $data1 = $single_attribute->getData();
         $attr_data["product_id"] = $product_data_model->getProductId();
         $attr_data["attribute_id"] = $data1[0]->getAttributeId();
         $attr_data["value"] = $value;

         // print_r($data1[0]->getAttributeId());
      }
      $tablename = $product_gallrey->getResource()->getTablename();
      $count_images = count($_FILES[$tablename]["name"]["images"]);
      // print_r($_FILES["catalog_media_gallrey"]["name"]["images"]);
      // print(count($_FILES["catalog_media_gallrey"]["name"]["images"]));
      for ($i = 0; $i < $count_images; $i++) {
         if ($_FILES[$tablename]["name"]["images"][$i] && $_FILES[$tablename]["error"]["images"][$i] == 0) {

            $base_dir = Mage::getBaseDir();
            $upload_dir = $base_dir . DS . "media" . DS .  $tablename;

            if (!file_exists($upload_dir)) {
               mkdir($upload_dir, 0755, true);
            }

            $tmp_name = $_FILES[$tablename]["tmp_name"]["images"][$i];
            $filename = basename($_FILES[$tablename]["name"]["images"][$i]);
            $upload_path = $upload_dir . DS . $filename;

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
      print($product_gallrey->getProductId());
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

      print_r($request_single2);
   }
}
