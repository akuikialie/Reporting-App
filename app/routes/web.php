<?php

$app->get('/home', 'App\Controllers\web\HomeController:index')->setName('home');
$app->get('/user/list', 'App\Controllers\web\UserController:listUser')->setName('user.list.all');

$app->get('/user/trash', 'App\Controllers\web\UserController:trashUser')->setName('user.trash');

$app->get('/user/adduser', 'App\Controllers\web\UserController:getCreateUser')->setName('user.create');

$app->post('/user/adduser', 'App\Controllers\web\UserController:postCreateUser')->setName('user.create.post');
$app->get('/user/del/{id}', 'App\Controllers\web\UserController:softDelete')->setName('user.del');

$app->get('/user/delete/{id}', 'App\Controllers\web\UserController:hardDelete')->setName('user.delt');

$app->get('/user/restore/{id}', 'App\Controllers\web\UserController:restoreData')->setName('user.restore');

$app->get('/user/edit/{id}', 'App\Controllers\web\UserController:getUpdateData')->setName('user.edit.data');
$app->post('/user/edit/{id}', 'App\Controllers\web\UserController:postUpdateData')->setName('user.edit.data');

