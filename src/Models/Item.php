<?php

namespace App\Models;

class Item extends BaseModel
{
    protected $table = 'items';
    protected $column = ['id', 'name'];

    public function create($data)
    {
        $date = date('Y-m-d H:i:s');
        $data = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'recurrent'   => $data['recurrent'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'group_id'    => $data['group_id'],
            'updated_at'  => $date
        ];

        $this->createData($data);

        return $this->db->lastInsertId();
    }

    public function update($data, $id)
    {
        $date = date('Y-m-d H:i:s');
        $data = [
            'name'        => $data['name'],
            'description' => $data['description'],
            'recurrent'   => $data['recurrent'],
            'start_date'  => $data['start_date'],
            'end_date'    => $data['end_date'],
            'group_id'    => $data['group_id'],
            'updated_at'  => $date
        ];

        $this->updateData($data, $id);

        // return $this->db->lastInsertId();
    }

}
