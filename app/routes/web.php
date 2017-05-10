<?php


$app->group('/admin', function() use ($app, $container) {

    $this->get('/home', 'App\Controllers\web\HomeController:index')->setName('home');
    $this->get('/group', 'App\Controllers\web\GroupController:index')->setName('group.list');
    $this->get('/group/inactive', 'App\Controllers\web\GroupController:inActive')->setName('group.inactive');
    $this->get('/group/detail/{id}', 'App\Controllers\web\GroupController:findGroup')->setName('group.detail');
    $this->get('/group/create', 'App\Controllers\web\GroupController:getAdd')->setName('create.group.get');
    $this->post('/group/create', 'App\Controllers\web\GroupController:add')->setName('create.group.post');
    $this->get('/group/edit/{id}', 'App\Controllers\web\GroupController:getUpdate')->setName('edit.group.get');
    $this->post('/group/edit/{id}', 'App\Controllers\web\GroupController:update')->setName('edit.group.post');
    $this->post('/group/active', 'App\Controllers\web\GroupController:setInactive')->setName('group.set.inactive');
    $this->post('/group/inactive', 'App\Controllers\web\GroupController:setActive')->setName('group.set.active');
    $this->get('/group/{id}/users', 'App\Controllers\web\GroupController:getMemberGroup')->setName('user.group.get');
    $this->post('/group/users', 'App\Controllers\web\GroupController:setUserGroup')->setName('user.group.set');
    $this->get('/group/{id}/allusers', 'App\Controllers\web\GroupController:getNotMember')->setName('all.users.get');
    $this->post('/group/allusers', 'App\Controllers\web\GroupController:setMemberGroup')->setName('member.group.set');

    });
