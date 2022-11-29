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
    $router->get('/property', 'PropertyController@getAll');
    $router->post('/singin', 'SessionController@createAccount');
    $router->post('/login', 'SessionController@login');

    //Routes for Reservation Module
    $router->get('/reservation', 'ReservationController@getAll');
    $router->post('/reservation', 'ReservationController@createReservation');

    //Routes for Property Module
    $router->get('/property', 'PropertyController@getAll');//Ready to work
    $router->post('/Createproperty', 'PropertyController@createProperty');//Ready to work
    $router->post('/Updateproperty/{id}', 'PropertyController@updateProperty');//Ready to work
    $router->post('/Upsertproperty', 'PropertyController@upsertProperty');
    $router->post('/Deleteproperty/{id}', 'PropertyController@deleteProperty');

});
//ola