<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\GroupModel;


class GroupController extends BaseController
{

	function index(Request $request, Response $response)
	{
		$group = new \App\Models\GroupModel($this->db);

		$getGroup = $group->getAll();

		$countGroups = count($getGroup);

		if ($getGroup) {
			$page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
			$get = $group->paginate($page, $getGroup, 10);
			if ($get) {
				$data = $this->responseDetail(200, 'Data Available', $get, $this->paginate($countGroups, 10, $page, ceil($countGroups/10)));
			} else {
				$data = $this->responseDetail(404, 'Error', 'Data Not Found');
			}
		} else {
			$data = $this->responseDetail(204, 'Succes', 'No Content');
		}

		return $data;
	}

	public function add(Request $request, Response $response)
	{
		$rules = [
			'required' => [
				['name'],
				['description'],
				['image'],
			]
		];

		$this->validator->rules($rules);

		$this->validator->labels([
			'name' 			=>	'Name',
			'description'	=>	'Description',
			'image'			=>	'Image',
		]);

		if ($this->validator->validate()) {
			$group = new \App\Models\GroupModel($this->db);
			$addGroup = $group->add($request->getParsedBody());

			$findNewGroup = $group->find('id', $addGroup);

			$data = $this->responseDetail(201, 'Group succefully added', $findNewGroup);
		} else {
			$data = $this->responseDetail(400, 'Errors', $this->validator->errors());
		}

		return $data;
	}
	public function update(Request $request, Response $response, $args)
	{
		$group = new \App\Models\GroupModel($this->db);
		$findGroup = $group->find('id', $args['id']);
		if ($findGroup) {
			$group->updateData($request->getParsedBody(), $args['id']);
			$afterUpdate = $group->find('id', $args['id']);

			$data = $this->responseDetail(200, 'Group data has been updated successfully', $afterUpdate);
		} else {
			$data = $this->responseDetail(404, 'Error', 'Data Not Found');
		}

		return $data;
	}

	public function delete(Request $request, Response $response, $args)
	{
		$group = new \App\Models\GroupModel($this->db);
		$findGroup = $group->find('id', $args['id']);

		if ($findGroup) {
			$group->hardDelete($args['id']);

			$data = $this->responseDetail(200, 'Succes', 'Group has Been Delete');
		} else {
			$data = $this->responseDetail(404, 'Error', 'Data Not Found');
		}

		return $data;
	}
}

?>
