<?php

$app->get('/', 'App\Controllers\HomeController:index')->setName('home');

$app->group('/article', function(){
    $this->get('/list', 'App\Controllers\ArticleController:index')->setName('article.list');
    $this->put('/edit/{id}', 'App\Controllers\ArticleController:update');
    $this->post('/add', 'App\Controllers\ArticleController:add');
    $this->delete('/delete/{id}', 'App\Controllers\ArticleController:delete');
});

$app->group('/group', function(){
    $this->get('/list', 'App\Controllers\GroupController:index');
    $this->put('/edit/{id}', 'App\Controllers\GroupController:update');
    $this->post('/add', 'App\Controllers\GroupController:add');
    $this->delete('/delete/{id}', 'App\Controllers\GroupController:delete');
});

$app->group('/user', function(){
    $this->get('/list', 'App\Controllers\UserController:index')->setname('user.list');
    $this->post('/add', 'App\Controllers\UserController:createUsers')->setname('user.add');
    $this->put('/update/{id}', 'App\Controllers\UserController:updateUser')->setname('user.update');
    $this->delete('/delete/{id}', 'App\Controllers\UserController:deleteUser')->setname('user.delete');
    $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');
});
