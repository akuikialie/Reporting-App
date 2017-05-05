<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\HomeController:index')->setName('home');
    $app->post('/login', 'App\Controllers\UserController:login')->setname('user.login');
    $app->post('/register', 'App\Controllers\UserController:createUser')->setname('user.login');

    $app->group('', function() use ($app, $container) {
        $app->group('/user', function() use ($app, $container) {
            $this->post('/register', 'App\Controllers\UserController:createUser')->setname('user.add');
            $this->get('/logout', 'App\Controllers\UserController:logout')->setname('user.logout');
            $this->put('/edit', 'App\Controllers\UserController:editAccount')->setname('edit.account');
            $this->delete('/delete', 'App\Controllers\UserController:delAccount')->setname('delete.account');
            $this->get('/detail', 'App\Controllers\UserController:detailAccount')->setname('user.detail');
            $this->get('/{group}/{id}', 'App\Controllers\GroupController:getUserGroup');
            $this->get('/item/lists', '\App\Controllers\ItemController:getAllItemUser')->setname('all_item_user');
            $this->get('/item/{group}', '\App\Controllers\ItemController:getItemUser')->setname('item_user');
            $this->post('/item/create', 'App\Controllers\ItemController:createItem')->setname('create_item');
            $this->get('/article', 'App\Controllers\ArticleController:index')->setName('article.list');
        });

        $app->group('/admin', function() use ($app, $container)  {
            $app->get('/logout', 'App\Controllers\UserController:logout')->setname('user.logout');
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
                $this->get('/{group}/users', 'App\Controllers\GroupController:getAllUserGroup');
                $this->get('/{group}/{id}', 'App\Controllers\GroupController:getUserGroup');
                $this->post('/user/add', 'App\Controllers\GroupController:setUserGroup');
                $this->delete('/user/delete/{group}/{id}', 'App\Controllers\GroupController:deleteUser');
                $this->put('/setpic/{group}/{id}', 'App\Controllers\GroupController:setAsPic');
                $this->put('/setmember/{group}/{id}', 'App\Controllers\GroupController:setAsMember');
                $this->put('/setguardian/{group}/{id}', 'App\Controllers\GroupController:setAsGuardian');
            });
            $app->group('/item', function(){
                $this->get('/list', 'App\Controllers\ItemController:index')->setname('item');
                $this->get('/{id}', 'App\Controllers\ItemController:getDetailItem')->setname('detail_item');
                $this->post('/create', 'App\Controllers\ItemController:createItem')->setname('create_item');
                $this->put('/update/{id}', 'App\Controllers\ItemController:updateItem')->setname('update_item');
                $this->delete('/delete/{id}', 'App\Controllers\ItemController:deleteItem')->setname('delete_item');
                $this->get('/{group}/{id}', '\App\Controllers\ItemController:getItemUser')->setname('item_user');
                $this->post('/{group}/{id}', '\App\Controllers\ItemController:setItemStatus')->setname('item_status');
                $this->get('/list/user/{id}', '\App\Controllers\ItemController:getAllItemUser')->setname('all_item_user');
            });
            $app->group('/user', function(){
                $this->get('/list', 'App\Controllers\UserController:index')->setname('user.list');
                $this->post('/adduser', 'App\Controllers\UserController:createUsers')->setname('user.add');
                $this->put('/update/{id}', 'App\Controllers\UserController:updateUser')->setname('user.update');
                $this->delete('/delete/{id}', 'App\Controllers\UserController:deleteUser')->setname('user.delete');
                $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');
                $this->post('/item/{group}', 'App\Controllers\UserController:SetItemUser')->setname('user.item');
            });
        })->add(new \App\Middlewares\AdminMiddleware($container));


        $app->group('/pic', function() use ($app, $container)  {
            $app->get('/logout', 'App\Controllers\UserController:logout')->setname('user.logout');
            $app->group('/article', function(){
                $this->get('/list', 'App\Controllers\ArticleController:index')->setName('article.list');
            });
            $app->group('/group', function(){
                $this->get('/{group}/users', 'App\Controllers\GroupController:getAllUserGroup');
                $this->get('/{group}/{id}', 'App\Controllers\GroupController:getUserGroup');
                $this->post('/user/add', 'App\Controllers\GroupController:setUserGroup');
                $this->delete('/user/delete/{group}/{id}', 'App\Controllers\GroupController:deleteUser');
            });
            $app->group('/item', function(){
                $this->get('/{id}', 'App\Controllers\ItemController:getDetailItem')->setname('detail_item');
                $this->post('/create', 'App\Controllers\ItemController:createItem')->setname('create_item');
                $this->put('/update/{id}', 'App\Controllers\ItemController:updateItem')->setname('update_item');
                $this->delete('/delete/{id}', 'App\Controllers\ItemController:deleteItem')->setname('delete_item');
                $this->get('/item/lists', '\App\Controllers\ItemController:getAllItemUser')->setname('all_item_user');
                $this->get('/item/{group}', '\App\Controllers\ItemController:getItemUser')->setname('item_user');
                $this->post('/{group}/{id}', '\App\Controllers\ItemController:setItemStatus')->setname('item_status');
            });
            $app->group('/user', function(){
                $this->post('/register', 'App\Controllers\UserController:createUser')->setname('user.add');
                $this->put('/edit', 'App\Controllers\UserController:editAccount')->setname('edit.account');
                $this->delete('/delete', 'App\Controllers\UserController:delAccount')->setname('delete.account');
                $this->get('/detail', 'App\Controllers\UserController:detailAccount')->setname('user.detail');
                $this->get('/list', 'App\Controllers\UserController:index')->setname('user.list');
                $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');
                $this->post('/item/{group}', 'App\Controllers\UserController:SetItemUser')->setname('user.item');
            });
        })->add(new \App\Middlewares\PicMiddleware($container));

        $app->group('/guard', function(){
            $this->get('/logout', 'App\Controllers\UserController:logout')->setname('user.logout');
            $this->get('/find/{id}', 'App\Controllers\UserController:findUser')->setname('user.find');
            $this->get('/list/item/{id}', '\App\Controllers\ItemController:getAllItemUser')->setname('all_item_user');
        })->add(new \App\Middlewares\GuardMiddleware($container));
    })->add(new \App\Middlewares\AuthToken($container));
});
