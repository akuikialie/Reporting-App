<?php 

namespace App\Controllers\web;
use App\Models\Users\UserModel;

class UserController extends BaseController
{
    public function listUser($request, $response)
    {
        $user = new UserModel($this->db);

        $datauser = $user->getAllUser();
        $data['user'] = $datauser;
        return $this->view->render($response, 'users/list.twig', $data);
    }

    public function getCreateUser($request, $response)
    {
        return  $this->view->render($response, 'users/add.twig');
    }

    public function postCreateUser($request, $response)
    {
        $storage = new \Upload\Storage\FileSystem('assets/images');
        $image = new \Upload\File('image',$storage);
        $image->setName(uniqid());
        $image->addValidations(array(
            new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
            'image/jpg', 'image/jpeg')),
            new \Upload\Validation\Size('5M')
        ));

        $data = array(
          'name'       => $image->getNameWithExtension(),
          'extension'  => $image->getExtension(),
          'mime'       => $image->getMimetype(),
          'size'       => $image->getSize(),
          'md5'        => $image->getMd5(),
          'dimensions' => $image->getDimensions()
        );
        $user = new UserModel($this->db);

        $this->validator
            ->rule('required', ['username', 'password', 'name', 'email', 'phone', 'address', 'gender'])
            ->message('{field} must not be empty')
            ->label('Username', 'password', 'name', 'Password', 'Email', 'Address');
        $this->validator
            ->rule('integer', 'id');
        $this->validator
            ->rule('email', 'email');
        $this->validator
            ->rule('alphaNum', 'username');
        $this->validator
             ->rule('lengthMax', [
                'username',
                'name',
                'password'
             ], 30);

        $this->validator
             ->rule('lengthMin', [
                'username',
                'name',
                'password'
             ], 5);

        if ($this->validator->validate()) {
            $image->upload();
            $user->createUser($request->getParams(), $data['name']);
            return $response->withRedirect($this->router
                    ->pathFor('user.list.all'));
            $this->flash->addMessage('succes', ' Data successfully added');
             return $response->withRedirect($this->router
                    ->pathFor('user.list.all'));
        } else {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $request->getParams();
            
            $this->flash->addMessage('info');
            return $response->withRedirect($this->router
                    ->pathFor('user.create'));
        }
    }
    public function getUpdateData($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $profile = $user->find('id', $args['id']);
        $data['data'] = $profile;

        return $this->view->render($response, 'users/edit.twig',
            $data);
    }
    public function postUpdateData($request, $response, $args)
    {
        $user = new UserModel($this->db);

        $this->validator
            ->rule('required', ['username', 'name', 'email', 'phone', 'address', 'gender'])
            ->message('{field} must not be empty')
            ->label('Username', 'password', 'name', 'Password', 'Email', 'Address');
        $this->validator
            ->rule('integer', 'id');
        $this->validator
            ->rule('email', 'email');
        $this->validator
            ->rule('alphaNum', 'username');
        $this->validator
             ->rule('lengthMax', [
                'username',
                'name',
                'password'
             ], 30);

        $this->validator
             ->rule('lengthMin', [
                'username',
                'name',
                'password'
             ], 5);

        if ($this->validator->validate()) {
            if (!empty($_FILES['image']['name'])) {
                $storage = new \Upload\Storage\FileSystem('assets/images');
                $image = new \Upload\File('image', $storage);
                $image->setName(uniqid());
                $image->addValidations(array(
                    new \Upload\Validation\Mimetype(array('image/png', 'image/gif',
                    'image/jpg', 'image/jpeg')),
                    new \Upload\Validation\Size('5M')
                ));
                $data = array(
                    'name'       => $image->getNameWithExtension(),
                    'extension'  => $image->getExtension(),
                    'mime'       => $image->getMimetype(),
                    'size'       => $image->getSize(),
                    'md5'        => $image->getMd5(),
                    'dimensions' => $image->getDimensions()
                );
                $image->upload();
                $user->update($request->getParams(), $data['name'], $args['id']);
            } else {
                $user->updateData($request->getParams(), $args['id']);
            }
            return $response->withRedirect($this->router->pathFor('user.list.all'));
        } else {
            $_SESSION['old'] = $request->getParams();
            $_SESSION['errors'] = $this->validator->errors();
            return $response->withRedirect($this->router->pathFor('user.edit.data', ['id' => $args['id']]));            
        }
    }

    public function softDelete($request, $response, $args) 
    {
        $user = new UserModel($this->db);
        $sofDelete = $user->softDelete($args['id']);
        $this->flash->addMessage('remove', '');
        return $response->withRedirect($this->router
                        ->pathFor('user.list.all'));
    }

    public function hardDelete($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $hardDelete = $user->hardDelete($args['id']);
        $this->flash->addMessage('delete', '!');
        return $response->withRedirect($this->router
                        ->pathFor('user.trash'));
    }

    public function trashUser($request, $response)
    {
        $user = new UserModel($this->db);

        $datauser = $user->trash();
        $data['usertrash'] = $datauser;
        return $this->view->render($response, 'users/trash.twig', $data);
    }

    public function restoreData($request, $response, $args)
    {
        $user = new UserModel($this->db);
        $restore = $user->restoreData($args['id']);
        $this->flash->addMessage('restore', '');
        return $response->withRedirect($this->router
                        ->pathFor('user.trash'));
    }
}
