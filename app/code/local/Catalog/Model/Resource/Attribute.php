<?php
class Catalog_Model_Resource_Attribute extends Core_Model_Resource_Abstract
{
    public function __construct()
    {
        $this->init("catalog_attribute", "attribute_id");
    }
}
