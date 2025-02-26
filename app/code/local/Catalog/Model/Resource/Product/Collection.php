<?php
class Catalog_Model_Resource_Product_Collection extends Core_Model_Resource_Collection_Abstract
{
    public function addAttributeToSelect($attributes)
    {
        print_r($attributes);
        foreach ($attributes as $attribute) {
            $a = Mage::getModel("catalog/attribute")
                ->load($attribute, "name");
            $attribute_id = $a->getAttributeId();
            $this->joinLeft(
                ["cpa_{$a->getName()}" => "catalog_product_attribute"],
                "main_table.product_id=cpa_{$a->getName()}.product_id AND cpa_{$a->getName()}.attribute_id={$attribute_id}",
                [$a->getName() => "value"]
            );
        }
        print_r($this);
        // print_r($this->_select);
        return $this;
    }
}
