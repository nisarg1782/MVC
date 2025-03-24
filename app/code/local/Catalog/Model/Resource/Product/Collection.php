<?php
class Catalog_Model_Resource_Product_Collection extends Core_Model_Resource_Collection_Abstract
{
    public function addAttributeToSelect($attributes)
    {
        // print_r($attributes);
        foreach ($attributes as $attribute) {
            // print_r($attribute);
            $a = Mage::getModel("catalog/attribute")
                ->load($attribute, "name");

            // echo "<pre>";
            // print_r($a->getName());


            $attribute_id = $a->getAttributeId();
            $this->joinLeft(
                ["cpa_{$a->getName()}" => "catalog_product_attribute"],
                "main_table.product_id=cpa_{$a->getName()}.product_id AND cpa_{$a->getName()}.attribute_id={$attribute_id}",
                [$a->getName() => "value"]
            );
        }
        // print_r($this);
        // die;
        // print_r($this->_select);
        return $this;
    }
    
    public function addCategoryFilter($category_id)
    {

        return $this->addFieldToFilter(
            "category_id",
            ["IN" => $category_id]
        );

        // echo "<pre>";
        // print_r($data);
        // return $this;
    }
    public function addAttributeToFilter($attribute, $value)
    {
        $this->addAttributeToSelect([$attribute]);
        // echo "123";
        // print_r($value);
        $key = array_keys($value);
        // print_r($key);
        // $value1=implode("','",$value[$key[0]]);
        // print($value1);
        $this->addFieldToFilter("cpa_{$attribute}.value", ["IN" => $value]);
    }
}
