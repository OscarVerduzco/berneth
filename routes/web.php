<?php

use App\Http\Controllers\Controller;
/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "te amo nat gama";
});
$router->get('/api/test', function () use ($router) {
    
    return $response->json(PropertyController::getAll());
}); 



$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/user', 'UserController@index');
    $router->get('/property', 'PropertyController@getAll');
    $router->post('/singin', 'SessionController@createAccount');
    $router->post('/login', 'SessionController@login');


});
//ola