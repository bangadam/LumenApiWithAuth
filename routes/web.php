<?php

$app->get('/', function() use ($app) {
    $res['success'] = true;
    $res['message'] = "Belajar Api dengan Lumen";
    return response($res);
});

$app->post('/login', 'LoginController@index');
$app->post('/register', 'UserController@register');
$app->get('/user/{id}', [
    'middleware' => 'auth',
    'uses'  =>  'UserController@get_user',
]);

