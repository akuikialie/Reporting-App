<?php

namespace App\Models;

class GroupModel extends BaseModel
{
	protected $table = 'groups';
	protected $column = ['name', 'description', 'image', 'deleted'];

	function add(array $data)
	{
		$data = [
			'name' 			=> 	$data['name'],
			'description'	=>	$data['description'],
			'image'			=>	$data['image'],
		];
		$this->createData($data);

		return $this->db->lastInsertId();
	}

	// public function getAllData()
    // {
    //     $qb = $this->db->createQueryBuilder();
    //     $qb->select('*')
    //         ->from($this->table);
    //     $query = $qb->execute();
    //     return $query->fetchAll();
    // }
}
?>
