<?php

$app->get('/home', 'App\Controllers\web\HomeController:index')->setName('home');
$app->get('/user/list', 'App\Controllers\web\UserController:listUser')->setName('user.list.all');

$app->group('/admin', function() use ($app, $container) {

    $app->group('/group', function(){
        $this->get('', 'App\Controllers\web\GroupController:index')->setName('group.list');
        $this->get('/inactive', 'App\Controllers\web\GroupController:inActive')->setName('group.inactive');
        $this->get('/detail/{id}', 'App\Controllers\web\GroupController:findGroup')->setName('group.detail');
        $this->get('/create', 'App\Controllers\web\GroupController:getAdd')->setName('create.group.get');
        $this->post('/create', 'App\Controllers\web\GroupController:add')->setName('create.group.post');
        $this->get('/edit/{id}', 'App\Controllers\web\GroupController:getUpdate')->setName('edit.group.get');
        $this->post('/edit/{id}', 'App\Controllers\web\GroupController:update')->setName('edit.group.post');
        $this->post('/active', 'App\Controllers\web\GroupController:setInactive')->setName('group.set.inactive');
        $this->post('/inactive', 'App\Controllers\web\GroupController:setActive')->setName('group.set.active');
        $this->get('/{id}/users', 'App\Controllers\web\GroupController:getMemberGroup')->setName('user.group.get');
        $this->post('/users', 'App\Controllers\web\GroupController:setUserGroup')->setName('user.group.set');
        $this->get('/{id}/allusers', 'App\Controllers\web\GroupController:getNotMember')->setName('all.users.get');
        $this->post('/allusers', 'App\Controllers\web\GroupController:setMemberGroup')->setName('member.group.set');
    });

    $app->group('/user', function(){
        $this->get('/trash', 'App\Controllers\web\UserController:trashUser')->setName('user.trash');
        $this->get('/adduser', 'App\Controllers\web\UserController:getCreateUser')->setName('user.create');
        $this->post('/adduser', 'App\Controllers\web\UserController:postCreateUser')->setName('user.create.post');
        $this->get('/del/{id}', 'App\Controllers\web\UserController:softDelete')->setName('user.del');
        $this->get('/delete/{id}', 'App\Controllers\web\UserController:hardDelete')->setName('user.delt');
        $this->get('/restore/{id}', 'App\Controllers\web\UserController:restoreData')->setName('user.restore');
        $this->get('/edit/{id}', 'App\Controllers\web\UserController:getUpdateData')->setName('user.edit.data');
        $this->post('/edit/{id}', 'App\Controllers\web\UserController:postUpdateData')->setName('user.edit.data');
    });
});
