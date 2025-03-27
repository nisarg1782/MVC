<?php
class Admin_Block_Widget_Grid_Filter_Dropdown extends Admin_Block_Widget_Grid_Filter_Abstract
{
    protected $_data;
    public function __construct()
    {
        // $this->setTemplate("admin/widget/grid/filter/dropdown.phtml");

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
        $options = "";
        foreach ($this->_data['options'] as $key => $opt) {
            $options .= "<option value='{$key}'>{$opt}</option>";
        }

        return "<select name='{$this->_data['label']}'>
                <option value=''>Select Status</option>
                {$options}
            </select>";
    }
}
