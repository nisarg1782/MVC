<?php
class Admin_Block_Widget_Grid extends Core_Block_Template
{
    protected $_columns = [];
    protected $_collection;
    public function __construct()
    {
        
        $layout = $this->getLayout();
        $toolbar_block = $layout->createBlock("Admin/widget_grid_toolbar")
            ->setTemplate("admin/widget/grid/toolbar.phtml");

        $this->addChild("toolbar", $toolbar_block);

        $toolbar_block->prepareToolbar();

        $this->setTemplate("admin/widget/grid.phtml");
    }
    public function addColumns($key, $data)
    {
        
        $obj=Mage::getBlock("Admin_Block_Widget_Grid_Column_".$data["column"]);
        // $obj=new $class;
        $obj->setData($data);
        $this->_columns[$key] = $obj;
        // echo '<pre>';
        // print_r($this->_columns);
        // echo '</pre>';
        
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    public function getColumns()
    {
        return $this->_columns;
    }
    public function getColumnData($key)
    {
        return isset($this->_columns[$key]) ? $this->_columns[$key] : null;
    }
    public function getFilter($field)
    {
        $data = $this->getColumnData($field);
        if (
            isset($data["filter"]) &&
            $data["filter"] != ""
        ) {
            $class = "Admin_Block_Widget_Grid_Filter_" . $data["filter"];

            if (class_exists($class)) {
                $obj = new $class;
                $obj->setData($data);
                echo $obj->toHtml(); // Ensure the HTML is echoed to output
            } else {
                echo "<td>Invalid filter class: {$class}</td>"; // Handle missing filter classes
            }
        }
    }
    
    public function getValue($collection, $coloumns)
    {

        $data = $collection->getData();

        if (in_array($coloumns["data_index"], array_keys($data))) {
            // print("in if");
            $class = "Admin_Block_Widget_Grid_Column_" . $coloumns["column"];
            $obj = new $class;

            $obj->setData($coloumns, $data);
            $obj->toHtml();
        }
    }
    public function applyFilters()
    {
        $filters=$_POST;
        echo '<pre>';
        print_r($filters);
        echo '</pre>';
        die;
        $filter_vals = array_filter($filter, function ($value) {
            return $value !== ""; // Keeps only non-empty values
        });

        $collection = $this->getCollection();
        if (!empty($filter_vals)) {
            foreach ($filter_vals as $key => $value) {
                if (str_ends_with($key, "_min")) {
                    $field = substr($key, 0, strpos($key, "_min"));
                    $collection->addFieldToFilter($field, [">=" => $value]); // Corrected operator

                } elseif (str_ends_with($key, "_max")) {
                    $field = substr($key, 0, strpos($key, "_max"));
                    $collection->addFieldToFilter($field, ["<=" => $value]); // Corrected operator

                } else {
                    $field = $key; // Assign the field directly
                    $collection->addFieldToFilter($field, ["=" => $value]);
                }
            }
        }
        echo '<pre>';
        print_r($collection->prepareQuery());
        echo '</pre>';
        // return $collection;
    }
    
}
    
    

    
    

