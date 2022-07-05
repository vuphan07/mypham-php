<?php
class BaseModel extends Database
{
    public static  $connect;
    public function __construct()
    {
        self::$connect = $this->connect();
    }
    public function findAll($table, $select = ["*"])
    {
        $select = implode(',', $select);
        $sql = "SELECT ${select} FROM ${table}";
        $data = $this->_query($sql);
        return  $data;
    }
    public function findById($table, $id, $select = ["*"])
    {
        $select = implode(',', $select);
        $sql = "SELECT ${select} FROM ${table} WHERE id = '${id}'";
        $data = $this->_query($sql);
        return  $data;
    }
    public function update($table, $id, $data = [])
    {
        if (count($data) === 0) {
            return true;
        }
        $dataUpdate = '';
        foreach ($data as $key => $val) {
            $dataUpdate = $dataUpdate . "${key} = '${val}'" . ",";
        }
        $dataUpdate = substr($dataUpdate, 0, -1);
        $sql = "UPDATE ${table} SET ${dataUpdate} WHERE id = '${id}'";
        $result = $this->_mutation($sql);
        if ($result) {
            return [
                "status" => "success",
                "message" => "updated ${id}"
            ];
        } else {
            return ["status" => "fail"];
        }
    }
    public function create($table, $data = [])
    {
        if (count($data) === 0) {
            return null;
        }
        $keys = implode(",", array_keys($data));
        $dataValue = array_map(function ($value) {
            return "'" . $value . "'";
        }, $data);
        $values = implode(",", ($dataValue));
        $sql = "INSERT INTO ${table} (${keys}) VALUES (${values})";

        $result = $this->_mutation($sql);
        if ($result) {
            return  $result;
        } else {
            return null;
        }
    }
    public function delete($table, $id)
    {
        $sql = "DELETE FROM ${table} WHERE id = '${id}'";
        $result = $this->_mutation($sql);
        if ($result) {
            return [
                "status" => "success",
                "message" => "deleted ${id}"
            ];
        } else {
            return ["status" => "fail"];
        }
    }

    protected function _query($sql)
    {
        $result = self::$connect->query($sql);

        $data = [];
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, $row);
                }
            }
        }
        return [
            "data" => $data,
        ];
    }

    protected function _mutation($sql)
    {
        if (self::$connect->query($sql) === TRUE) {
            if (self::$connect->insert_id) {
                return  self::$connect->insert_id;
            }
            return  true;
        } else {
            return false;
        }
    }
}
