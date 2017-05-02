<?php

namespace App\Models;

class UserGroupModel extends BaseModel
{
	protected $table = 'user_group';
	protected $column = ['group_id', 'user_id', 'status'];

	function add(array $data)
	{
		$data = [
			'group_id' 	=> 	$data['group_id'],
			'user_id'	=>	$data['user_id'],
		];
		$this->createData($data);

		return $this->db->lastInsertId();
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
			->where($column1 . ' = '. $param1 .'&&'. $column2 . ' = '. $param2);
		$result = $qb->execute();
		return $result->fetch();
	}

	public function setPic($id)
	{
		$qb = $this->db->createQueryBuilder();
		$qb->update($this->table)
		   ->set('status', 1)
		   ->where('id = ' . $id)
		   ->execute();
	}

	public function setGuardian($id)
	{
		$qb = $this->db->createQueryBuilder();
		$qb->update($this->table)
		   ->set('status', 2)
	 	   ->where('id = ' . $id)
		   ->execute();
	}

	public function setUser($id)
	{
		$qb = $this->db->createQueryBuilder();
		$qb->update($this->table)
		   ->set('status', 0)
 	   	   ->where('id = ' . $id)
		   ->execute();
	}
}

?>
