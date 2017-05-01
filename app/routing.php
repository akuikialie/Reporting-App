<?php 

$app->get('/', 'App\Controllers\HomeController:index')->setname('home');

// ---------------- Routing User --------------------- //
$app->get('/user/list', 'App\Controllers\UserController:index')->setname('user.list');

$app->post('/user/adduser', 'App\Controllers\UserController:createUsers')->setname('user.add');

$app->put('/user/update/{id}', 'App\Controllers\UserController:updateUser')->setname('user.update');

$app->delete('/user/delete/{id}', 'App\Controllers\UserController:deleteUser')->setname('user.delete');

$app->get('/user/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');




