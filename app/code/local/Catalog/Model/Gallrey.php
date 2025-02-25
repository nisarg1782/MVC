<?php
class Catalog_Model_Gallrey extends Core_Model_Abstract
{
    public function init()
    {
        $this->_resourceClassName="Catalog_Model_Resource_Gallrey";
        $this->_collectionClassName="Catalog_Model_Resource_Gallrey_Collection";
    }
}
?>