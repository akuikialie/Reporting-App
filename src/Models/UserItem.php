<?php

namespace App\Models;

class UserItem extends BaseModel
{
    protected $table = 'user_item';
    protected $jointTable = 'items';
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

    public function getItem($groupId, $userId)
    {
        $qb = $this->db->createQueryBuilder();

        $parameters = [
            ':user_id' => $userId,
            ':group_id' => $groupId
        ];

        $qb->select('it.name', 'it.description', 'it.recurrent', 'it.start_date', 'it.end_date', 'it.status')
        ->from($this->jointTable, 'it')
        ->join('it', $this->table, 'ui', 'ui.item_id = it.id')
        ->where('ui.user_id = :user_id')
        ->andWhere('ui.group_id = :group_id')
        ->setParameters($parameters);

        $result = $qb->execute();

        return $result->fetchAll();
    }

}
