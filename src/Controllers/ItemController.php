<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Item;
use App\Models\UserItem;

class ItemController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $item = new \App\Models\Item($this->db);

        $getItems = $item->getAll();

        if ($getItems) {
            $data = $this->responseDetail(200, 'Data Available', $getItems);
        } else {
            $data = $this->responseDetail(400, 'Data not found', null);
        }

        return $data;
    }

    public function getItemUser(Request $request, Response $response, $args)
    {
        $userItem = new UserItem($this->db);
        $item = new Item($this->db);

        $findUserItem = $userItem->findUser('group_id', $args['group'], 'user_id', $args['id']);
        $findItem = $item->find('id', $findUserItem['item_id']);

        $getItem = $userItem->getItemGroup($args['group'], $args['id']);

        if ($findUserItem) {
            $data = $this->responseDetail(200, 'Data Available', $getItem);
        } else {
            $data = $this->responseDetail(400, 'Error', 'User item not found');

        }

        return $data;
    }

    public function getAllItemUser(Request $request, Response $response, $args)
    {
        $userItem = new UserItem($this->db);
        $item     = new Item($this->db);

        $findUserItem = $userItem->find('user_id', $args['id']);

        $findItem  = $item->find('id', $findUserItem['item_id']);
        // var_dump($findUserItem['item_id']);
        // die();
        $getItem = $userItem->getItem($args['id']);

        if ($findUserItem) {
            $data = $this->responseDetail(200, 'Data available', $getItem);
        } else {
            $data = $this->responseDetail(400, 'Error', 'User item not found');
        }

        return $data;
    }

    public function setItemStatus(Request $request, Response $response, $args)
    {
        $userItem = new UserItem($this->db);

        $findUserItem = $userItem->findUser('group_id', $args['group'], 'user_id', $args['id']);


        if ($findUserItem) {
            $userItem->setStatusItem($findUserItem['id']);
            $data = $this->responseDetail(200, 'Item done', $findUserItem);
        } else {
            $data = $this->responseDetail(400, 'error', 'Item not found');
        }

        return $data;
    }

    public function getDetailItem(Request $request, Response $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $data['status']  = 200;
            $data['message']  = 'Completed';
            $data['data']  = $findItem;
        } else {
            $data['status']  = 400;
            $data['message']  = 'Item not found';
        }

        return $this->responseWithJson($data);
    }

    public function createItem(Request $request, Response $response)
    {
        $rules = [
            'required' => [
                ['name'],
                ['recurrent'],
                ['description'],
                ['start_date'],
                ['end_date'],
                ['group_id'],
            ],

        ];

        $this->validator->rules($rules);

        $this->validator->labels([
            'name'        => 'Name',
            'recurrent'   => 'Recurrent',
            'description' => 'Description',
            'start_date'  => 'Start date',
            'end_date'    => 'End date',
            'group_id'    => 'Group id'
        ]);

        if ($this->validator->validate()) {
            $item = new Item($this->db);
            $newItem = $item->create($request->getParsedBody());
            $recentItem = $item->find('id', $newItem);

            $data = $this->responseDetail(201, 'New item successfully added', $recentItem);

        } else {

            $data = $this->responseDetail(400, 'Error occured', $this->validator->errors());
        }

        return $data;
    }

    public function updateItem(Request $request, Response $response, $args)
    {
        $item     = new Item($this->db);
        $findItem = $item->find('id', $args['id']);

        if ($findItem) {
            $rules = [
                'required' => [
                    ['name'],
                    ['recurrent'],
                    ['description'],
                    ['start_date'],
                    ['end_date'],
                    ['group_id'],
                ],

            ];

            $this->validator->rules($rules);

            $this->validator->labels([
                'name'        => 'Name',
                'recurrent'   => 'Recurrent',
                'description' => 'Description',
                'start_date'  => 'Start date',
                'end_date'    => 'End date',
                'group_id'    => 'Group id'
            ]);


            if ($this->validator->validate()) {
                $item = new \App\Models\Item($this->db);
                $updateItem = $item->update($request->getParsedBody(), $args['id']);
                $recentItemUpdated = $item->find('id', $args['id']);

                $data = $this->responseDetail(200, 'Item successfully updated', $recentItemUpdated);

            } else {

                $data = $this->responseDetail(400, 'Error occured', $this->validator->errors());
            }
        } else {
            $data = $this->responseDetail(400, 'Item not found', null);
        }

        return $data;
    }

    public function deleteItem(Request $request, Response $response, $args)
    {
        $item = new Item($this->db);

        $findItem = $item->find('id', $args['id']);

        if ($findItem) {

            $item->hardDelete($args['id']);
            $data['status']= 200;
            $data['message']= 'Item deleted';

        } else {
            $data['status']= 400;
            $data['message']= 'Item not found';
        }

        return $this->responsewithJson($data);

    }


}
