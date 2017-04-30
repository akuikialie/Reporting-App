<?php 

$app->get('/', 'App\Controllers\HomeController:index')->setName('home');

$app->get('/article/list', 'App\Controllers\ArticleController:index')->setName('article.list');
$app->put('/article/edit/{id}', 'App\Controllers\ArticleController:update');
$app->post('/article/add', 'App\Controllers\ArticleController:add');
$app->delete('/article/delete/{id}', 'App\Controllers\ArticleController:delete');
