<?php
class OrderItemModel extends BaseModel
{
    const TABLE = 'orderitems';

    public function getAll($select = ["*"])
    {
        return $this->findAll(self::TABLE, $select);
    }

    public function getById($id, $select = ["*"])
    {
        return $this->findById(self::TABLE, $id, $select);
    }

    public function deleteById($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    public function deleteByOrderId($id)
    {
        $table = self::TABLE;
        $sql = "DELETE FROM ${table} WHERE user_id = '${id}'";
        return $this->_mutation($sql);
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
