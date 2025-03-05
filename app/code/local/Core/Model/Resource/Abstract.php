<?php

class Core_Model_Resource_Abstract
{
    protected $_tableName = "";
    protected $_primaryKey = "";

    public function _construct()
    {
        return $this;
    }
    public function getTablename()
    {
        return $this->_tableName;
    }
    public function __construct()
    {
        $this->_construct();
    }
    public function init($tableName, $primaryKey)
    {
        $this->_tableName = $tableName;
        $this->_primaryKey = $primaryKey;
    }
    public function getAdapter()
    {
        return new Core_Model_DB_Adapter();
    }
    public function load($value, $field = null)
    {
        $field = (is_null($field)) ? $this->_primaryKey : $field;
        $sql = "SELECT * FROM {$this->_tableName} WHERE {$field}='$value'  LIMIT 1";
        return $this->getAdapter()->fetchRow($sql);
    }
    public function delete($model)
    {
        $data = $model->getData();
        // print_r($data);

        $sql = "DELETE FROM {$this->_tableName} WHERE {$this->_primaryKey}=$data";
        //print("the sql is ".$sql);

        return $this->getAdapter()->query($sql);
    }
    protected function _getDbColumns()
    {
        $sql = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME ='{$this->getTablename()}'";
        $columns = $this->getAdapter()->fetchCol($sql);
        // print_r($columns);
        return $columns;
    }
    public function save($model)
    {
        $db_columns = $this->_getDbColumns();

        $primary_id = 0;
        $data = $model->getData();

        $sql = "";
        $conditions = [];
        if (isset($data[$this->_primaryKey]) && $data[$this->_primaryKey]) {


            $primary_id = $data[$this->_primaryKey];
            unset($data[$this->_primaryKey]);

            foreach ($data as $key => $val) {
                if (in_array($key, $db_columns)) {


                    $conditions[] = sprintf(" `{$key}` ='%s'", addslashes($val));
                }
            }
            //print_r($conditions);
            $sql = "UPDATE {$this->_tableName} SET" . implode(",", $conditions) . " WHERE {$this->_primaryKey} = " . $primary_id;
            // print($sql);

            return $this->getAdapter()->query($sql);
        } else {

            $cols = [];
            $values = [];
            foreach ($data as $key => $value) {
                if (in_array($key, $db_columns)) {
                    $cols[] = $key;
                    $values[] = $value;
                }
            }
            $columns = implode("`,`", $cols);
            $_values = implode("','", $values);


            $sql = sprintf(
                "INSERT INTO %s (`%s`) VALUES ('%s')",
                $this->_tableName,
                $columns,
                $_values
            );

            $id = $this->getAdapter()->insert($sql);

            $model->{$this->_primaryKey}=$id;
            // print_r($model);



            return $id;
        }
        //print(get_class($model));

    }
    
}
