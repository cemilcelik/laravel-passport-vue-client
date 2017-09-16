<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    try {

        $client = new GuzzleHttp\Client;
        
        $response = $client->post('http://laravel-passport-vue.int/oauth/token', [
            'form_params' => [
                'client_id'     => 1,
                'client_secret' => 'NlEiIWavjeS1Eykyyk4NGbgeJZvCCtFqPDbwMytD',
                'grant_type'    => 'password',
                'username'      => 'mail@mail.com',
                'password'      => 'secret',
                'scope'         => '*'
            ]
        ]);
    
        $auth = json_decode((string) $response->getBody());
        
        $response = $client->get('http://laravel-passport-vue.int/api/todos', [
            'headers' => [
                'Authorization' => 'Bearer ' . $auth->access_token
            ]
        ]);
    
        dd(json_decode((string) $response->getBody()));

    } catch (GuzzleHttp\Exception\BadResponseException $e) {
        echo "Unable to retrieve access token.";
    }

    return view('welcome');

});
