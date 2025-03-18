<?php

class Core_Model_Resource_Collection_Abstract
{
    protected $_resourcename;
    protected $_model;
    protected $_select = [];
    public function setResource($resource)
    {
        $this->_resourcename = $resource;
        return $this;
    }
    public function setModel($model)
    {
        $this->_model = $model;
        return $this;
    }
    public function select($columns = ["*"])
    {
        $this->_select['FROM'] = ["main_table" => $this->_resourcename->getTableName()];
        $this->_select['COLUMNS'] = [];
        $columns = is_array($columns) ? $columns : [$columns];
        foreach ($columns as $alias=>$column) {
            // Mage::log($alias);
            // Mage::log($column);
            // die;
            if(is_integer($alias))
            {
                $this->_select['COLUMNS'][] = "main_table." . $column;

            }else{
                $this->_select['COLUMNS'][] = $alias . " AS ". $column;
            }
        }
        return $this;
    }

    public function getdata()
    {

        // $sql = sprintf("SELECT %s FROM %s", implode(",", $this->_select["COLUMNS"]), $this->_select["FROM"]);
        // print_r($this->prepareQuery());

        $data = $this->_resourcename->getAdapter()->FetchAll($this->prepareQuery());
        //print_r($data);
        foreach ($data as &$_data) {

            $_model = new $this->_model;
            $_data = $_model->setdata($_data);
        }
        return $data;
    }
    public function addFieldToFilter($field, $condition)
    {
        if (!is_array($condition)) {
            $condition = ["=" => $condition];
        }
        $this->_select["WHERE"][$field][] = $condition;

        return $this;
    }


    public function prepareQuery()
    {
        $query = sprintf("SELECT %s FROM %s AS %s", implode(",", $this->_select["COLUMNS"]), array_values($this->_select["FROM"])[0], array_keys($this->_select["FROM"])[0]);
        $where = [];

        $join_sql = "";

        if (isset($this->_select['LEFT_JOIN'])) {
            $leftjoinsql = "";
            foreach ($this->_select["LEFT_JOIN"] as $leftjoin) {
                $leftjoinsql .= sprintf(
                    " LEFT JOIN %s AS %s ON %s ",
                    array_values($leftjoin['tablename'])[0],
                    array_keys($leftjoin['tablename'])[0],
                    $leftjoin['condition']
                );
            }
            $query .= " " . $leftjoinsql;
        }
        if (isset($this->_select["JOIN_RIGHT"])) {
            foreach ($this->_select["JOIN_RIGHT"] as $join_right) {
                $join_sql .= sprintf("RIGHT JOIN %s ON %s", $join_right['tablename'], $join_right['conditions']);
            }
            $query .= " " . $join_sql;
        }

        if (isset($this->_select["JOIN_INNER"])) {

            foreach ($this->_select["JOIN_INNER"] as $innerjoin) {
                $join_sql .= sprintf(
                    " INNER JOIN %s AS %s ON %s ",
                    array_values($innerjoin['tablename'])[0],
                    array_keys($innerjoin['tablename'])[0],
                    $innerjoin['condition']
                );
            }
            $query .= " " . $join_sql;
        }

        if (isset($this->_select["CROSS_JOIN"])) {
            foreach ($this->_select["CROSS_JOIN"] as $cross_join) {
                $join_sql .= sprintf("CROSS JOIN %s WHERE %s", $cross_join["tablename"], $cross_join['conditions']);
            }
            $query .= " " . $join_sql;
        }
        if (isset($this->_select["FULL_OUTER_JOIN"])) {
            foreach ($this->_select["FULL_OUTER_JOIN"] as $full_join) {
                $join_sql .= sprintf("FULL OUTER JOIN %s ON %s", $full_join["tablename"], $full_join["conditions"]);
            }
            $query .= " " . $join_sql;
        }

        if (isset($this->_select["WHERE"])) {
            $wheresql = "";
            //$count = count($this->_select["WHERE"]);
            foreach ($this->_select["WHERE"] as $field => $value) {
                $where[] = $this->prepareWhere($field, $value);
            }
            $wheresql .= " WHERE ";
            $wheresql .= implode(" AND ", $where);
            //print_r($wheresql);

            $query .= $wheresql;
        }
        if (isset($this->_select["GROUP_BY"])) {
            $group = [];
            foreach ($this->_select["GROUP_BY"] as $group_by) {
                //print_r($group_by);
                $group = $group_by["columns_g"];
            }
            $query .= " GROUP BY " . implode(",", $group);
        }
        if (isset($this->_select["HAVING"])) {
            $havingsql = "";
            $having = [];
            foreach ($this->_select["HAVING"] as $filed => $value) {
                //print_r("the filed is " . $filed . "and the value is " . $value);
                $having[] = $this->prepareWhere($filed, $value);
            }
            // print_r($having);
            if (isset($this->_select["GROUP_BY"])) {
                $havingsql = " HAVING " . implode(" AND ", $having);
            } else {
                $havingsql = " WHERE " . implode(" AND ", $having);
            }
            $query .= $havingsql;
            // print($havingsql);

        }

        if (isset($this->_select["LIMIT"])) {
            $limit_query = "";
            foreach ($this->_select["LIMIT"] as $limit_arr) {
                $limit_query .= " LIMIT " . $limit_arr["limit"] . " OFFSET " . $limit_arr["offset"];
            }
            $query .= $limit_query;
        }
        if (isset($this->_select["ORDER"])) {
            $order_query = "";
            $order_group = [];
            foreach ($this->_select["ORDER"] as $key => $val) {
                $order_group[] = " " . $key . " " . $val . " ";
            }
            $order_query = " ORDER BY " . implode(",", $order_group);
            $query .= $order_query;
        }
        return $query;
    }
    public function prepareWhere($field, $value)
    {
        if (!empty($field) and !empty($value)) {
            if (is_array($value)) {
                foreach ($value as $_v) {
                    foreach ($_v as $op => $_value) {
                        switch (strtoupper($op)) {
                            case "IN":
                            case "NOT IN":
                                $_value = is_array($_value) ? $_value : explode(',', $_value); // Ensure it's an array
                                $quotedValues = "'" . implode("', '", array_map('trim', $_value)) . "'"; // Trim spaces and format
                                $where = "$field $op ($quotedValues)";
                                break;



                            case "LIKE":
                            case "NOT LIKE":
                                $where = "$field $op '" . addslashes($_value) . "'";
                                break;

                            case "BETWEEN":
                            case "NOT BETWEEN":
                                if (is_array($_value) && count($_value) == 2) {
                                    $where = "$field $op '" . addslashes($_value[0]) . "' AND '" . addslashes($_value[1]) . "'";
                                }
                                break;

                            case "=":
                            case ">":
                            case "<":
                            case ">=":
                            case "<=":
                            case "<>":
                            case "eq":
                            case "!=":
                                $where = "$field $op '$_value'"; // add for string match
                                break;

                            default:
                                throw new Exception("Unsupported operator: $op");
                        }
                    }
                }
            }
            if (($where) >= 0) {
                return $where;
            }
        }
    }
    public function joinLeft($tableName, $condition, $columns)
    {
        $this->_select["LEFT_JOIN"][] = [
            "tablename" => $tableName,
            "condition" => $condition,
            "columns" => $columns
        ];
        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf(
                "%s.%s AS %s",
                array_keys($tableName)[0],
                $columnname,
                $alias
            );
        }
        return $this;
    }
    public function joinRight($tablename, $condition, $columns)
    {
        $this->_select["JOIN_RIGHT"][] = ["tablename" => $tablename, "conditions" => $condition, "columns" => $columns];
        foreach ($columns as $alias => $_column) {
            $this->_select["COLUMNS"][] = sprintf("%s.%s AS %s", $tablename, $_column, $alias);
        }
        return $this;
    }
    public function innerJoin($tableName, $condition, $columns)
    {
        $this->_select["JOIN_INNER"][] = [
            "tablename" => $tableName,
            "condition" => $condition,
            "columns" => $columns
        ];
        foreach ($columns as $alias => $columnname) {
            $this->_select['COLUMNS'][] = sprintf(
                "%s.%s AS %s",
                array_keys($tableName)[0],
                $columnname,
                $alias
            );
        }
        return $this;
    }
    public function crossJoin($tablename, $conditions, $columns)
    {
        $this->_select["CROSS_JOIN"][] = ['tablename' => $tablename, "columns" => $columns, "conditions" => $conditions];
        foreach ($columns as $alias => $_columns) {
            $this->_select["COLUMNS"][] = sprintf("%s.%s AS %s", $tablename, $_columns, $alias);
        }

        return $this;
    }
    public function fullOuterJoin($tablename, $conditions, $columns)
    {
        $this->_select["FULL_OUTER_JOIN"][] = ['tablename' => $tablename, "columns" => $columns, "conditions" => $conditions];
        foreach ($columns as $alias => $_columns) {
            $this->_select["COLUMNS"][] = sprintf("%s.%s AS %s", $tablename, $_columns, $alias);
        }
        return $this;
    }
    public function GroupBy($cols)
    {
        $this->_select["GROUP_BY"][] = ["columns_g" => $cols];
        return $this;
    }
    public function Limit($limit, $offset = 0)
    {

        $this->_select["LIMIT"][] = ["limit" => $limit, "offset" => $offset];
        return $this;
    }
    public function orderBy($order)
    {
        $this->_select["ORDER"] = $order;
        return $this;
    }
    public function having($field, $conditions)
    {
        if (!is_array($conditions)) {
            $condition = ["=" => $conditions];
        } else {
            foreach ($conditions as $op => $_value) {
                $condition = [$op => $_value];
            }
        }
        $this->_select["HAVING"][$field][] = $condition;
        return $this;
    }
    public function alias($field, $aliasName)
    {
        $this->_select["COLUMNS"][] = sprintf("%s.%s AS %s", $this->_resourcename->getTablename(), $field, $aliasName);
        return $this;
    }
    private function getTableAlias($table)
    {
        return array_keys($table)[0];
    }
    private function getTableName($table)
    {
        return array_values($table)[0];
    }


    //     SELECT A.CustomerName AS CustomerName1, 
    //        B.CustomerName AS CustomerName2, 
    //        A.City
    // FROM Customers A
    // JOIN Customers B 
    //     ON A.City = B.City 


    // public function selfJoin($tablename,$columns)
    // {
    //     $this->_select["SELF_JOIN"][]=["tablename"=>$tablename,"columns"=>$columns];
    //     foreach($tablename as $tablename=>$alias)
    //     {
    //         $this->_select["tablename_self"][]=sprintf("%s.%s AS %s")
    //     }
    // }
    public function getFirstItem()
    {
        $firstData = $this->getData();
        if (isset($firstData[0])) {
            return $firstData[0];
        } else {
            return $this->_model;
        }
    }
}
