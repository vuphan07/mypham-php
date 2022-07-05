<?php
class StatusModel extends BaseModel
{
    const TABLE = 'statusorders';

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

    public function updateById($id, $data)
    {
        return $this->update(self::TABLE, $id, $data);
    }

    public function store($data)
    {
        return $this->create(self::TABLE, $data);
    }
}
