<?php
class Catalog_Block_Product_List_Products extends Catalog_Block_Product_List
{
    protected $_collection;
    public function __construct()
    {
        $this->setTemplate("catalog/product/list/products.phtml");
        $this->init();
    }
    public function init()
    {
        $toolbar = $this->getLayout()->createBlock("catalog/grid_toolbar")
            ->setTemplate("catalog/grid/toolbar.phtml");
        $this->addChild("toolbar", $toolbar);
        $this->_collection = Mage::getModel("catalog/filter")
            ->getProductCollection()
            ->joinLeft(
                ["cmg_img" => "catalog_media_gallery"],
                "main_table.product_id=cmg_img.product_id and cmg_img.default_file_path=1",
                ["image" => "file_path"]
            );

        $toolbar->prepareToolbar();
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function productData()
    {

        return $this->getCollection()->getData();
    }
}
