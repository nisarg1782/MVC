<?php
class Catalog_Block_Grid_Toolbar extends Core_Block_Template
{
    protected $_page;
    protected $_limit;
    protected $_collection;
    public function __construct() {}
    public function prepareToolbar()
    {
        $page = $this->getRequest()->getQuery("page");
        $limit = $this->getRequest()->getQuery("limit");
        $this->_collection = clone $this->getParent()
            ->getCollection();
        if (
            is_numeric($page) &&
            $page >= 1
        ) {
            $this->_page = $page;
        } else {
            $this->_page = 1;
        }
        if (
            is_numeric($limit) &&
            $limit >= 1
        ) {
            $this->_limit = $limit;
        } else {
            $this->_limit = $this->getTotalRecords();
        }
            $this->getParent()
            ->getCollection()
            ->Limit($this->_limit, $this->_page);
    }
    public function getLimit()
    {
        return $this->_limit;
    }
    public function getPage()
    {
        return $this->_page;
    }
    public function getTotalRecords()
    {
        return count($this->_collection->getData());
    }
}
