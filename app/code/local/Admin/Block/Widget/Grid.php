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


   
    public function capturevalues($data) {
        // Enable detailed error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    
        // Ensure the response is always JSON
        header("Content-Type: application/json");
    
        // Check if the input is valid JSON
        if (!empty($data) && is_array($data)) {
            echo json_encode([
                "status" => "success",
                "received_data" => $data
            ]);
        } else {
            // Log any issue to a file (useful for debugging)
            error_log("Invalid data received: " . print_r($data, true));
    
            // Return a proper error response
            echo json_encode([
                "status" => "error",
                "message" => "No data received or invalid JSON"
            ]);
        }
    }
    
}
    
    

    
    

