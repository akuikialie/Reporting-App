<?php 

namespace App\Models;

class UserItem extends BaseModel
{
    protected $table = 'user_item';
    protected $column = ['item_id', 'user_id', 'status', 'group_id'];

    public function setItem(array $data, $group)
    {
        $datas =   
        [
            "user_id" => $data['user_id'],
            "item_id" => $data['item_id'],
            "group_id" => $group,
        ];

        $this->createData($datas);
    }

    public function setStatusItem($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->update($this->table)
            ->set('status', 1)
            ->where('id = ' . $id)
            ->execute();
    }

    public function findUser($column1, $val1, $column2, $val2)
    {
        $param1 = ':'.$column1;
        $param2 = ':'.$column2;
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
            ->from($this->table)
            ->setParameter($param1, $val1)
            ->setParameter($param2, $val2)
            ->where($column1 . ' = '. $param1 . '&&' . $column2 . '=' . $param2);
        $result = $qb->execute();
        return $result->fetch();
    }
    
}