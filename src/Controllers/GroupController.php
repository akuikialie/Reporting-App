<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\GroupModel;
use App\Models\UserGroupModel;


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

	function findGroup(Request $request, Response $response, $args)
	{
		$group = new \App\Models\GroupModel($this->db);
		$findGroup = $group->find('id', $args['id']);

		if ($findGroup) {
			$data = $this->responseDetail(200, 'Succes', $findGroup);
		} else {
			$data = $this->responseDetail(404, 'Error', 'Data Not Found');
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

			$data = $this->responseDetail(200, 'Succes', 'Group successfully deleted');
		} else {
			$data = $this->responseDetail(404, 'Error', 'Data Not Found');
		}

		return $data;
	}

	public function setUserGroup(Request $request, Response $response)
	{
		$rules = [
			'required' => [
				['group_id'],
				['user_id'],
			]
		];

		$this->validator->rules($rules);

		$this->validator->labels([
			'group_id' 	=>	'ID Group',
			'user_id'	=>	'ID User',
		]);

		if ($this->validator->validate()) {
			$userGroup = new \App\Models\UserGroupModel($this->db);
			$adduserGroup = $userGroup->add($request->getParsedBody());

			$findNewGroup = $userGroup->find('id', $adduserGroup);

			$data = $this->responseDetail(201, 'User successfully added to group', $findNewGroup);
		} else {
			$data = $this->responseDetail(400, 'Errors', $this->validator->errors());
		}

		return $data;
	}

	public function deleteUser(Request $request, Response $response, $args)
	{
		$userGroup = new \App\Models\UserGroupModel($this->db);
		$finduserGroup = $userGroup->findUser('user_id', $args['id'], 'group_id', $args['group']);
		$finduserGroup = $userGroup->find('user_id', $args['id']);

		if ($finduserGroup) {
			$userGroup->hardDelete($finduserGroup['id']);

			$data = $this->responseDetail(200, 'Success', 'User has been deleted from group');
		} else {
			$data = $this->responseDetail(404, 'Error', 'Data Not Found');
		}

		return $data;
	}

	public function setAsMember(Request $request, Response $response, $args)
	{
		$userGroup = new \App\Models\UserGroupModel($this->db);
		$finduserGroup = $userGroup->findUser('user_id', $args['id'], 'group_id', $args['group']);

		if ($finduserGroup) {
			$userGroup->setUser($finduserGroup['id']);

			$data = $this->responseDetail(200, 'Success', 'User successfully set as member');
		} else {
			$data = $this->responseDetail(404, 'Error', 'User not found in group');
		}

		return $data;
	}

	public function setAsPic(Request $request, Response $response, $args)
	{
		$userGroup = new \App\Models\UserGroupModel($this->db);
		$finduserGroup = $userGroup->findUser('user_id', $args['id'], 'group_id', $args['group']);

		if ($finduserGroup) {
			$userGroup->setPic($finduserGroup['id']);

			$data = $this->responseDetail(200, 'Success', 'User successfully set as PIC');
		} else {
			$data = $this->responseDetail(404, 'Error', 'User not found in group');
		}

		return $data;
	}

	public function setAsGuardian(Request $request, Response $response, $args)
	{
		$userGroup = new \App\Models\UserGroupModel($this->db);
		$finduserGroup = $userGroup->findUser('user_id', $args['id'], 'group_id', $args['group']);

		if ($finduserGroup) {
			$userGroup->setGuardian($finduserGroup['id']);

			$data = $this->responseDetail(200, 'Success', 'User successfully set as guardian');
		} else {
			$data = $this->responseDetail(404, 'Error', 'User not found in group');
		}

		return $data;
	}
}
