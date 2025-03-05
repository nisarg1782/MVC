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
        echo "<pre>";
        print_r($this);
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
            $value=$this->{$_attribute->getName()};
            if(isset($product_attribute[0]))
            {
                $product_attribute[0]->setValue($value)->save();

            }else{
                Mage::getModel("catalog/product_attribute")
                ->setAttributeId($_attribute->getAttributeId())
                ->setProductId($this->getProductId())
                ->setValue($value)
                ->save();
            }
            // print_r($value);
                // print_r($product_attribute);
        }
       
        //     $attr_data=$this->getadddata();
        //     $attribute_model=Mage::getModel("catalog/product_attribute");
        //    for($i=0;$i<count($attr_data);$i++)
        //    {
        //     $attr_data[$i]["product_id"]=$this->getProductId();
        //     $attribute_model->setdata($attr_data[$i]);
        //     $attribute_model->save();
        //    }

        //   print_r($this->getadddata());
        //   die;
        //    print_r($attr_data);

    }
}
