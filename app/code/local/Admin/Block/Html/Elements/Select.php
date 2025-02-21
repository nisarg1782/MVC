<?php
class Admin_Block_Html_Elements_Select
{
    protected $_data;
    public function __construct($data)
    {
        $this->_data = $data;
    }
    public function render()
    {
        $html = "<select>";
    }
}
