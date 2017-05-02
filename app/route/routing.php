<?php

$app->get('/', 'App\Controllers\HomeController:index')->setName('home');

$app->group('/article', function(){
    $app->get('/list', 'App\Controllers\ArticleController:index')->setName('article.list');
    $app->put('/edit/{id}', 'App\Controllers\ArticleController:update');
    $app->post('/add', 'App\Controllers\ArticleController:add');
    $app->delete('/delete/{id}', 'App\Controllers\ArticleController:delete');
});

$app->group('/group', function(){
    $app->get('/list', 'App\Controllers\GroupController:index');
    $app->put('/edit/{id}', 'App\Controllers\ArticleController:update');
    $app->post('/add', 'App\Controllers\ArticleController:add');
    $app->delete('/delete/{id}', 'App\Controllers\ArticleController:delete');
});
