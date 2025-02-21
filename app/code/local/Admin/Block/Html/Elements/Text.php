<?php
class Admin_Block_Html_Elements_Text
{
    protected $_data = [];
    protected $_field = "";

    public function __construct($field, $data)
    {
        $this->_data = $data;
        $this->_field = $field;
    }

    public function render()
    {
        $html = '<input type="' . $this->_field . '"';

        foreach ($this->_data as $key => $value) {
            $html .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
        }

        $html .= ' />';
        return $html;
    }
}
