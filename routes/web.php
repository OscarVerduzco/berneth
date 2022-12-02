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
    return "te amo nat gama <3";
});
$router->get('/api/test', function () use ($router) {
    
    return $response->json(PropertyController::getAll());
}); 



$router->group(['prefix' => 'api'], function () use ($router) {
    //Routes for Access Module
    $router->get('/user', 'UserController@index');
    $router->post('/singin', 'SessionController@createAccount');
    $router->post('/login', 'SessionController@login');

    //Routes for Users Module
    $router->group(['prefix' => 'user'], function () use ($router) {

        $router->get('/getall', 'UserController@index');
        $router->post('/getdel', 'UserController@getAllDel');
        $router->post('/upsert', 'UserController@upsertUser');
        $router->post('/delete', 'UserController@deleteUser');
        
        //$router->post('/create', 'UserController@createUser');
        //$router->post('/update', 'UserController@updateUser');
    });

    //Routes for Reservation Module
    $router->get('/reservation', 'ReservationController@getAll');
    $router->post('/reservation', 'ReservationController@createReservation');

    //Routes for Property Module
    $router->group(['prefix' => 'property'], function () use ($router) {
        $router->post('/getall', 'PropertyController@getAll');//Ready to work
        $router->post('/getdel', 'PropertyController@getAllDel');//Ready to work
        $router->post('/upsert', 'PropertyController@upsertProperty');//Ready to work
        $router->post('/delete', 'PropertyController@deleteProperty');//Ready to work
        //$router->post('/create', 'PropertyController@createProperty');//Ready to work
        //$router->post('/update/{id}', 'PropertyController@updateProperty');//Ready to work
    });
    


});
//ola 