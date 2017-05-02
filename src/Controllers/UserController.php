<?php 

namespace App\Controllers;

use App\Models\Users\UserModel;
use App\Models\Users\UserToken;
class UserController extends BaseController
{
   public function index($request, $response)
        {
            $user = new UserModel($this->db);

            $getUser = $user->getAllUser();
            $countUser = count($getUser);

            if ($getUser) {
                    $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
                    
                    $get = $user->paginate($page, $getUser, 5);

                    if ($get) {
                            $data = $this->responseDetail(200, 'Data Available', $get, $this->paginate($countUser, 5, $page, ceil($countUser/5)));
                    } else {
                            $data = $this->responseDetail(404, 'Error', 'Data Not Found');
                    }
            } else {
                    $data = $this->responseDetail(204, 'Success', 'No Content');
            }

            return $data;

        }

    // public function index($request, $response)
    // {
    //     $user = new UserModel($this->db);
    //     $setUser = $user->getAllUser();

    //     if ($setUser) 
    //     {
    //         $data = $this->responseDetail(201, 'Success', 'Create User Succes', $setUser);   
    //     } else {
    //         $data = $this->responseDetail(404, 'Error', 'Create User Succes');
    //     }
    //         return $data;
    // }

    public function createUsers($request, $response)
    {
        $this->validator->rule('required', ['name', 'email', 'username', 'password', 'gender', 'address', 'phone', 'image']);
        $this->validator->rule('email', 'email');
        $this->validator->rule('alphaNum', 'username');
        $this->validator->rule('numeric', 'phone');
        $this->validator->rule('lengthMin', ['name', 'email', 'username', 'password'], 5);
        $this->validator->rule('integer', 'id');

        if ($this->validator->validate()) {
            $user = new UserModel($this->db);
            $createUsers = $user->createUser($request->getParsedBody());

            $data = $this->responseDetail(201, 'Success', 'Create User Succes', $request->getParsedBody());
        } else {
            $data = $this->responseDetail(400, 'Errors', $this->validator->errors());
        }
            return $data;
    }

    public function deleteUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $findUser = $user->find('id', $args['id']);

        if ($findUser) {
            $user->hardDelete($args['id']);
            $data['id'] = $args['id'];
            $data = $this->responseDetail(200, 'Succes', 'Data Has Been Deleted', $data);
         } else {
            $data = $this->responseDetail(400, 'Errors', 'Data Not Found');
         }
            return $data;
    }

    public function updateUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $findUser = $user->find('id', $args['id']);

        if ($findUser) {
            $this->validator->rule('required', ['name', 'email', 'username', 'password', 'gender', 'address', 'phone', 'image']);
            $this->validator->rule('email', 'email');
            $this->validator->rule('alphaNum', 'username');
            $this->validator->rule('numeric', 'phone');
            $this->validator->rule('lengthMin', ['name', 'email', 'username', 'password'], 5);
            $this->validator->rule('integer', 'id');
            if ($this->validator->validate()) {
                $user->updateData($request->getParsedBody(), $args['id']);
                $data['update data'] = $request->getParsedBody();

                $data = $this->responseDetail(200, 'Succes', 'Update Data Succes', $data);
            } else {
                $data = $this->responseDetail(400, 'Errors', $this->validator->errors());              
            }
        } else {
             $data = $this->responseDetail(400, 'Errors', 'Data Not Found');
        }
            return $data;
    }

    public function findUser($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $findUser = $user->find('id', $args['id']);

        if ($findUser) {
            $data = $this->responseDetail(200, 'Succes', 'Update Data Succes', $findUser);
        } else {
            $data = $this->responseDetail(400, 'Errors', 'Data Not Found');
        }

            return $data;
    }

    public function login($request, $response)
    {
        $user = new UserModel($this->db);
        $login = $user->find('username', $request->getParam('username'));

        if (empty($login)) {
            $data = $this->responseDetail(401, 'Errors', 'username is not registered');
        } else {
            $check = password_verify($request->getParam('password'), $login['password']);
            if ($check) {
                $token = new UserToken($this->db);
                $token->setToken($login['id']);
                $getToken = $token->find('user_id', $login['id']);

                $key = [
                    'key' => $getToken,
                ];
                $data = $this->responseDetail(201, 'Login Succes', $login, $key);
            } else {
            $data = $this->responseDetail(401, 'Errors', 'Wrong Password');
            }
        }
            return $data;
    }

   public function itemUser($request, $response, $args)
   {
        $user = new UserModel($this->db);
        $findUser = $user->find('id', $request->getParsedBody()['user_id']);
        $group = new \App\Models\GroupModel($this->db);
        $findGroup = $group->find('id', $args['group']);

        $token = $request->getHeader('Authorization')[0];

        $userToken = new \App\Models\Users\UserToken($this->db);

        if ($findUser && $findGroup) {
        $data['user_id'] = $findUser['id'];
        $item = new \App\Models\UserItem($this->db);
        // $findUserGroup = $item->findUser('user_id', $args['id'], 'group_id', $args['group']);

        $this->validator->rule('required', ['item_id', 'user_id']);
        $this->validator->rule('integer', ['id']);


        if ($this->validator->validate()) {
            $item->setItem($request->getParsedBody(), $args['group']);
            $data = $request->getParsedBody();

            
            $data = $this->responseDetail(201, 'Succes managed to select the item', $data, $findUser);
        } else {
            $data['status_code'] = 400;
            $data['status_message'] = "Error";
            $data['data'] = $this->validator->errors();

            $data = $this->responseDetail(400, 'Errors', $this->validator->errors());


        }
            return $data;
            $items = $user->find('id', $args['id']);
            $item = $request->getParsedBody();

            $data = $this->responseDetail(201, 'user Succes Purchased', $items, $item);
            
            
        } else {
            $data = $this->responseDetail(404, 'Error', 'user Not Found');
        }

        return $data;

        }

}
