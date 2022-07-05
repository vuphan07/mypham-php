<?php
class OrderModel extends BaseModel
{
    const TABLE = 'orders';

    public function getAll($select = ["*"])
    {
        $sql = "SELECT orders.*,orderitems.product_id,orderitems.quantity,statusorders.name as namestatus,products.name as nameproduct, shippings.name as nameshipping FROM orders,orderitems,statusorders,products,shippings WHERE orders.id = orderitems.order_id AND orders.status = statusorders.id AND orderitems.product_id = products.id AND shippings.id = orders.shipping";
        $result = $this->_query($sql);
        return $result;
    }

    public function getAllMyOrders($select = ["*"])
    {
        $myinfo = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        if ($myinfo === null) {
            return null;
        }
        $sql = "SELECT orders.*,orderitems.product_id,orderitems.quantity,statusorders.name as namestatus,products.name as nameproduct, shippings.name as nameshipping FROM orders,orderitems,statusorders,products,shippings WHERE orders.id = orderitems.order_id AND orders.status = statusorders.id AND orderitems.product_id = products.id AND shippings.id = orders.shipping AND orders.user_id = ${myinfo['id']}";
        $result = $this->_query($sql);
        return $result;
    }

    public function getAllByUserId($user_id)
    {
        $table = self::TABLE;
        $sql = "SELECT * from ${table} where user_id = ${user_id}";
        $result = $this->_query($sql);
        return $result;
    }
    
    public function getTotal(){
        $sql = "SELECT sum(orders.cost)  AS 'total' from orders";
        $result = $this->_query($sql);
        return $result;
    }

    public function getById($id, $select = ["*"])
    {
        return $this->findById(self::TABLE, $id, $select);
    }

    public function deleteById($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    public function deleteByUserId($id)
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
