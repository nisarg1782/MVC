<?php
class Admin_Block_Widget_Grid_Filter_Text extends Admin_Block_Widget_Grid_Filter_Abstract
{
    protected $_data;
    public function __construct()
    {
        // $this->setTemplate("admin/widget/grid/filter/text.phtml");
    }

    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }
    public function getData()
    {
        return $this->_data;
    }
    public function renderTag()
    {
        return "<input type='{$this->_data['filter']}' 
       name='{$this->_data['label']}'
       placeholder='Enter {$this->_data['label']}' >";
    }
}
