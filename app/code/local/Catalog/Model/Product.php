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
        // echo $this->getProductStatus();

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
                ); // echo "<pre>";
            // print_r($collection->getData());
            // echo "</pre>";
            foreach ($collection->getData() as $_data) {
                $this->{$_data->getName()} = $_data->getValue();
            }
        }
        return $this;
    }
}
