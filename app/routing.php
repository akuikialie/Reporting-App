<?php

$app->get('/', 'App\Controllers\HomeController:index')->setname('home');

$app->get('/item', 'App\Controllers\ItemController:index')->setname('item');

$app->get('/item/{id}', 'App\Controllers\ItemController:getDetailItem')->setname('detail_item');

$app->post('/item/create', 'App\Controllers\ItemController:createItem')->setname('create_item');

$app->put('/item/update/{id}', 'App\Controllers\ItemController:updateItem')->setname('update_item');

$app->delete('/item/delete/{id}', 'App\Controllers\ItemController:deleteItem')->setname('delete_item');
