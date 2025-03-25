<?php
class Admin_Block_Widget_Grid extends Core_Block_Template
{
    protected $_columns = [];
    public function __construct()
    {
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/widget_grid_toolbar")
            ->setTemplate("admin/widget/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar_block);

        $toolbar_block->prepareToolbar();

        $this->setTemplate("admin/widget/grid.phtml");
        // $this->renderFilter();
    }
    public function addColumns($key, $data)
    {
        $this->_columns[$key] = $data;
    
    }
    public function getColumns()
    {
        return $this->_columns;
    }
    public function getColumnData($key)
    {
        return isset($this->_columns[$key]) ? $this->_columns[$key] : null;
    }
    public function renderFilter($field)
    {
        $data = $this->getColumnData($field);
        $class = "Admin_Block_Widget_Grid_Filter_" . $data["filter"];

        if (class_exists($class)) {
            $obj = new $class;
            $obj->setData($data);
            echo $obj->toHtml(); // Ensure the HTML is echoed to output
        } else {
            echo "<td>Invalid filter class: {$class}</td>"; // Handle missing filter classes
        }
    }
    public function getValue($col)
    {
        print($col);
        $data=$this->getColumnData($col);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

}
