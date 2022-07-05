<?php
class ProductModel  extends BaseModel
{
    const TABLE = 'products';

    public function getAll($select = ["*"])
    {
        return $this->findAll(self::TABLE, $select);
    }

    public function getAllEnoughQuantity($select = ["*"])
    {
        $sql = "SELECT * FROM products WHERE quantity > 0";
        return $this->_query($sql);
    }

    public function getById($id, $select = ["*"])
    {
        return $this->findById(self::TABLE, $id, $select);
    }

    public function getByKeyword($keyword, $select = ["*"])
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM ${table} WHERE name LIKE '%${keyword}%'";
        return $this->_query($sql);
    }

    public function getByCategory($id, $select = ["*"])
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM ${table} WHERE category_id = ${id}";
        return $this->_query($sql);
    }

    public function getProductsold()
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM ${table} WHERE sold > 0";
        return $this->_query($sql);
    }

    public function deleteById($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    public function updateById($id, $data)
    {
        return $this->update(self::TABLE, $id, $data);
    }

    public function store($data)
    {
        return $this->create(self::TABLE, $data);
    }
}
