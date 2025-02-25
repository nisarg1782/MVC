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
    public function load($value)
    {
        $sql = "SELECT * FROM {$this->_tableName} WHERE {$this->_primaryKey}=$value  LIMIT 1";
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
    public function save($model)
    {
        $primary_id = 0;
        $data = $model->getData();

        $sql = "";
        $conditions = [];

       
        if (isset($data[$this->_primaryKey]) && $data[$this->_primaryKey]) {


            $primary_id = $data[$this->_primaryKey];
            unset($data[$this->_primaryKey]);

            foreach ($data as $key => $val) {


                $conditions[] = sprintf(" `{$key}` ='%s'", addslashes($val));
            }
            //print_r($conditions);
            $sql = "UPDATE {$this->_tableName} SET" . implode(",", $conditions) . " WHERE {$this->_primaryKey} = " . $primary_id;
            // print($sql);

            return $this->getAdapter()->query($sql);
        } else {

            $cols = [];
            $values = [];
            foreach ($data as $key => $value) {
                $cols[] = $key;
                $values[] = $value;
            }
            $columns = implode("`,`", $cols);
            $_values = implode("','", $values);
            //$sql="INSERT INTO {$this->_tableName} (". implode(",",$cols).") VALUES (".implode(",",$values) .")";
            //$sql=sprintf("INSERT INTO %s (`%s`) VALUES (`%s`)",$this->_tableName,$columns,$_values);

            $sql = sprintf(
                "INSERT INTO %s (`%s`) VALUES ('%s')",
                $this->_tableName,
                $columns,
                $_values
            );
            //print($sql);
            $id = $this->getAdapter()->insert($sql);
            // print("id is " . $id);
            $model->load($id);
            return $id;
        }
        //print(get_class($model));

    }
}
