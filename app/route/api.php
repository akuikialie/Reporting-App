<?php

$app->get('/', 'App\Controllers\HomeController:index')->setName('home');

$app->group('/article', function(){
    $this->get('/list', 'App\Controllers\ArticleController:index')->setName('article.list');
    $this->put('/edit/{id}', 'App\Controllers\ArticleController:update');
    $this->post('/add', 'App\Controllers\ArticleController:add');
    $this->delete('/delete/{id}', 'App\Controllers\ArticleController:delete');
});

$app->group('/group', function(){
    $this->get('/find/{id}', 'App\Controllers\GroupController:findGroup');
    $this->get('/list', 'App\Controllers\GroupController:index');
    $this->put('/edit/{id}', 'App\Controllers\GroupController:update');
    $this->post('/add', 'App\Controllers\GroupController:add');
    $this->delete('/delete/{id}', 'App\Controllers\GroupController:delete');
    $this->post('/user/add', 'App\Controllers\GroupController:setUserGroup');
    $this->delete('/user/delete/{group}/{id}', 'App\Controllers\GroupController:deleteUser');
    $this->put('/setpic/{group}/{id}', 'App\Controllers\GroupController:setAsPic');
    $this->put('/setmember/{group}/{id}', 'App\Controllers\GroupController:setAsMember');
    $this->put('/setguardian/{group}/{id}', 'App\Controllers\GroupController:setAsGuardian');
});

// $app->group('/user', function(){
//     $this->get('/list', 'App\Controllers\UserController:index')->setname('user.list');
//     $this->post('/add', 'App\Controllers\UserController:createUsers')->setname('user.add');
//     $this->put('/update/{id}', 'App\Controllers\UserController:updateUser')->setname('user.update');
//     $this->delete('/delete/{id}', 'App\Controllers\UserController:deleteUser')->setname('user.delete');
//     $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');
// });

$app->group('/item', function(){
    $this->get('/list', 'App\Controllers\ItemController:index')->setname('item');
    $this->get('/{id}', 'App\Controllers\ItemController:getDetailItem')->setname('detail_item');
    $this->post('/create', 'App\Controllers\ItemController:createItem')->setname('create_item');
    $this->put('/update/{id}', 'App\Controllers\ItemController:updateItem')->setname('update_item');
    $this->delete('/delete/{id}', 'App\Controllers\ItemController:deleteItem')->setname('delete_item');
    $this->get('/{group}/{id}', '\App\Controllers\ItemController:getItemUser')->setname('item_user');
    $this->post('/{group}/{id}', '\App\Controllers\ItemController:setItemStatus')->setname('item_status');
});

$app->group('/user', function(){
    $this->post('/login', 'App\Controllers\UserController:login')->setname('user.login');
    $this->get('/list', 'App\Controllers\UserController:index')->setname('user.list');
    $this->post('/adduser', 'App\Controllers\UserController:createUsers')->setname('user.add');
    $this->put('/update/{id}', 'App\Controllers\UserController:updateUser')->setname('user.update');
    $this->delete('/delete/{id}', 'App\Controllers\UserController:deleteUser')->setname('user.delete');
    $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');

    // $this->post('/item/{id}', 'App\Controllers\UserController:itemUser')->setname('user.item');

    $this->post('/item/{group}', 'App\Controllers\UserController:itemUser')->setname('user.item');

});
