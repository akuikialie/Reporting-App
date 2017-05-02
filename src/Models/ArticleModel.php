<?php

namespace App\Models;

class ArticleModel extends BaseModel
{
	protected $table = 'articles';
	protected $column = ['title', 'content', 'image', 'deleted'];

	function add(array $data)
	{
		$data = [
			'title' 	=> 	$data['title'],
			'content'	=>	$data['content'],
			'image'		=>	$data['image'],
		];
		$this->createData($data);

		return $this->db->lastInsertId();
	}
}

?>
