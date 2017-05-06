<?php

$app->group('/api', function() use ($app, $container) {
    $app->get('/', 'App\Controllers\api\HomeController:index')->setName('home');
    $app->post('/login', 'App\Controllers\api\UserController:login')->setname('user.login');
    $app->post('/register', 'App\Controllers\api\UserController:createUser')->setname('user.login');

    $app->group('', function() use ($app, $container) {
        $app->group('/user', function() use ($app, $container) {
            $this->post('/register', 'App\Controllers\api\UserController:createUser')->setname('user.add');
            $this->get('/logout', 'App\Controllers\api\UserController:logout')->setname('user.logout');
            $this->put('/edit', 'App\Controllers\api\UserController:editAccount')->setname('edit.account');
            $this->delete('/delete', 'App\Controllers\api\UserController:delAccount')->setname('delete.account');
            $this->get('/detail', 'App\Controllers\api\UserController:detailAccount')->setname('user.detail');
            $this->get('/{group}/{id}', 'App\Controllers\api\GroupController:getUserGroup');
            // $this->get('/item/lists', '\App\Controllers\api\ItemController:getAllItemUser')->setname('all_item_user');
            $this->get('/item/{group}', '\App\Controllers\api\ItemController:getItemUser')->setname('item_user');
            $this->post('/item/create', 'App\Controllers\api\ItemController:createItem')->setname('create_item');
            $this->get('/article', 'App\Controllers\api\ArticleController:index')->setName('article.list');
        });

        $app->group('/admin', function() use ($app, $container)  {
            $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('user.logout');
            $app->group('/article', function(){
                $this->get('/list', 'App\Controllers\api\ArticleController:index')->setName('article.list');
                $this->put('/edit/{id}', 'App\Controllers\api\ArticleController:update');
                $this->post('/add', 'App\Controllers\api\ArticleController:add');
                $this->delete('/delete/{id}', 'App\Controllers\api\ArticleController:delete');
            });
            $app->group('/group', function(){
                $this->get('/find/{id}', 'App\Controllers\api\GroupController:findGroup');
                $this->get('/list', 'App\Controllers\api\GroupController:index');
                $this->put('/edit/{id}', 'App\Controllers\api\GroupController:update');
                $this->post('/add', 'App\Controllers\api\GroupController:add');
                $this->delete('/delete/{id}', 'App\Controllers\api\GroupController:delete');
                $this->get('/{group}/users', 'App\Controllers\api\GroupController:getAllUserGroup');
                $this->get('/{group}/{id}', 'App\Controllers\api\GroupController:getUserGroup');
                $this->post('/user/add', 'App\Controllers\api\GroupController:setUserGroup');
                $this->delete('/user/delete/{group}/{id}', 'App\Controllers\api\GroupController:deleteUser');
                $this->put('/setpic/{group}/{id}', 'App\Controllers\api\GroupController:setAsPic');
                $this->put('/setmember/{group}/{id}', 'App\Controllers\api\GroupController:setAsMember');
                $this->put('/setguardian/{group}/{id}', 'App\Controllers\api\GroupController:setAsGuardian');
            });
            $app->group('/item', function(){
                $this->get('/list', 'App\Controllers\api\ItemController:index')->setname('item');
                $this->get('/{id}', 'App\Controllers\api\ItemController:getDetailItem')->setname('detail_item');
                $this->post('/create', 'App\Controllers\api\ItemController:createItem')->setname('create_item');
                $this->put('/update/{id}', 'App\Controllers\api\ItemController:updateItem')->setname('update_item');
                $this->delete('/delete/{id}', 'App\Controllers\api\ItemController:deleteItem')->setname('delete_item');
                $this->get('/{group}/{id}', '\App\Controllers\api\ItemController:getItemUser')->setname('item_user');
                $this->post('/{group}/{id}', '\App\Controllers\api\ItemController:setItemStatus')->setname('item_status');
                $this->get('/list/user/{id}', '\App\Controllers\api\ItemController:getAllItemUser')->setname('all_item_user');
            });
            $app->group('/user', function(){
                $this->get('/list', 'App\Controllers\api\UserController:index')->setname('user.list');
                $this->post('/adduser', 'App\Controllers\api\UserController:createUsers')->setname('user.add');
                $this->put('/update/{id}', 'App\Controllers\api\UserController:updateUser')->setname('user.update');
                $this->delete('/delete/{id}', 'App\Controllers\api\UserController:deleteUser')->setname('user.delete');
                $this->get('/find/{id}', 'App\Controllers\api\UserController:findUser')->setname('user.find');
                $this->post('/item/{group}', 'App\Controllers\api\UserController:SetItemUser')->setname('user.item');
            });
        })->add(new \App\Middlewares\AdminMiddleware($container));


        $app->group('/pic', function() use ($app, $container)  {
            $app->get('/logout', 'App\Controllers\api\UserController:logout')->setname('user.logout');
            $app->group('/article', function(){
                $this->get('/list', 'App\Controllers\api\ArticleController:index')->setName('article.list');
            });
            $app->group('/group', function(){
                $this->get('/{group}/users', 'App\Controllers\api\GroupController:getAllUserGroup');
                $this->get('/{group}/{id}', 'App\Controllers\api\GroupController:getUserGroup');
                $this->post('/user/add', 'App\Controllers\api\GroupController:setUserGroup');
                $this->delete('/user/delete/{group}/{id}', 'App\Controllers\api\GroupController:deleteUser');
            });
            $app->group('/item', function(){
                $this->get('/{id}', 'App\Controllers\api\ItemController:getDetailItem')->setname('detail_item');
                $this->post('/create', 'App\Controllers\api\ItemController:createItem')->setname('create_item');
                $this->put('/update/{id}', 'App\Controllers\api\ItemController:updateItem')->setname('update_item');
                $this->delete('/delete/{id}', 'App\Controllers\api\ItemController:deleteItem')->setname('delete_item');
                $this->get('/item/lists', '\App\Controllers\api\ItemController:getAllItemUser')->setname('all_item_user');
                $this->get('/item/{group}', '\App\Controllers\api\ItemController:getItemUser')->setname('item_user');
                $this->post('/{group}/{id}', '\App\Controllers\api\ItemController:setItemStatus')->setname('item_status');
            });
            $app->group('/user', function(){
                $this->post('/register', 'App\Controllers\api\UserController:createUser')->setname('user.add');
                $this->put('/edit', 'App\Controllers\api\UserController:editAccount')->setname('edit.account');
                $this->delete('/delete', 'App\Controllers\api\UserController:delAccount')->setname('delete.account');
                $this->get('/detail', 'App\Controllers\api\UserController:detailAccount')->setname('user.detail');
                $this->get('/list', 'App\Controllers\api\UserController:index')->setname('user.list');
                $this->get('/find/{id}', 'App\Controllers\api\UserController:findUser')->setname('user.find');
                $this->post('/item/{group}', 'App\Controllers\api\UserController:SetItemUser')->setname('user.item');
            });
        })->add(new \App\Middlewares\PicMiddleware($container));

        $app->group('/guard', function(){
            $this->get('/logout', 'App\Controllers\api\UserController:logout')->setname('user.logout');
            $this->get('/find/{id}', 'App\Controllers\api\UserController:findUser')->setname('user.find');
            $this->get('/list/item/{id}', '\App\Controllers\api\ItemController:getAllItemUser')->setname('all_item_user');
        })->add(new \App\Middlewares\GuardMiddleware($container));
    })->add(new \App\Middlewares\AuthToken($container));
});
