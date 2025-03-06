<?php
class Catalog_Model_Product extends Core_Model_Abstract
{

    public function init()
    {
        $this->_resourceClassName = "Catalog_Model_Resource_Product";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Collection";
    }
    public $status = [
        '0' => "disabled",
        '1' => "enabled"
    ];
    public function getProductStatusText()
    {
        return isset($this->status[$this->getProductStatus()]) ? $this->status[$this->getProductStatus()] : "NA";
    }
    protected function _afterLoad()
    {
        if ($this->getProductId()) {
            $collection = Mage::getModel("catalog/product_Attribute")
                ->getcollection()
                ->addFieldToFilter("product_id", $this->getProductId())
                ->joinLeft(
                    ["attr" => "catalog_attribute"],
                    "attr.attribute_id = main_table.attribute_id",
                    ["name" => "name"]
                );

            $data = $collection->getData();

            foreach ($data as $_data) {
                $this->{$_data->getname()} = $_data->getvalue();
            }
        }
        return $this;
    }
    protected function _afterSave()
    {
        // echo "<pre>";
        // print_r($this);
        $attributes = Mage::getModel("catalog/attribute")->getCollection()->getData();
        foreach ($attributes as $_attribute) {
            // print_r($attribute->getAttributeId());
            // die;
            // print_r($attribute->getData());
            $product_attribute = Mage::getModel("catalog/product_attribute")->getCollection()
                ->addFieldToFilter("product_id", ["=" => $this->getProductId()])
                ->addFieldToFilter("attribute_id", ["=" => $_attribute->getAttributeId()])
                ->getData();
            // print_r($product_attribute);
            // die;
            $value = $this->{$_attribute->getName()};
            if (isset($product_attribute[0])) {
                $product_attribute[0]->setValue($value)->save();
            } else {
                Mage::getModel("catalog/product_attribute")
                    ->setAttributeId($_attribute->getAttributeId())
                    ->setProductId($this->getProductId())
                    ->setValue($value)
                    ->save();
            }
        }
            $image_data = $_FILES["catalog_product"];
            // print_r($image_data);
            $product_gallrey = Mage::getModel("catalog/gallrey");
            $main_img = $this->getMainImage();
            // print_r($main_img);
            $tablename = $this->getResource()->getTablename();
            print_r($tablename);

            $count_images = count($_FILES[$tablename]["name"]["images"]);
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


                    if (move_uploaded_file($tmp_name, $upload_path)) {


                        $data["file_path"] = $filename;
                        $data["type"] = "image";
                        $data["product_id"] = $this->getProductId();
                        $product_gallrey->setData($data);
                        $product_gallrey->save();
                    } else {
                    }
                } else {
                }
            }
        }
    }

