<?php
class Admin_Block_Widget_Grid_Filter_Link extends Core_Block_Template
{
    protected $_data;
    public function __construct()
    {
        $this->setTemplate("admin/widget/grid/filter/link.phtml");
    }
    public function getData()
    {
        return $this->_data;
    }
    public function setData($data)
    {
        $this->_data=$data;
        return $this;
    }
}
?>