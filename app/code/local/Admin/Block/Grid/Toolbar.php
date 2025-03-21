<?php
class Admin_Block_Grid_Toolbar extends Core_Block_Template
{
    protected $_limit = 5;
    protected $_page = 1;
    protected $_collection;

    public function __construct() {}
    public function prepareToolbar()
    {
        $page = $this->getRequest()->getQuery("page");
        $limit = $this->getRequest()->getQuery("limit");
        // print($this->_page);
        if (is_numeric($page)) {
            $this->_page = $page;
        }
        if (is_numeric($limit)) {

            $this->_limit = intval($limit);
        }

        $this->_collection = clone $this->getParent()
            ->getCollection();
        $this->getParent()
            ->getCollection()
            ->Limit($this->_limit, $this->_page)
            ->getData();
    }
    public function getTotalRecords()
    {
        return count($this->_collection->getData());
    }
}
