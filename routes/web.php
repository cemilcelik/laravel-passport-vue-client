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

use Illuminate\Http\Request;

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

});

Route::get('/welcome', function () {

    return view('welcome');
    
});

Route::get('/authorization-code', function () {

    $query = http_build_query([
        'client_id' => 4,
        'redirect_uri' => 'http://laravel-passport-vue-client.int/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    // return redirect("http://laravel-passport-vue.int/authorize?" . $query);
    return redirect("http://laravel-passport-vue.int/oauth/authorize?" . $query);

});

Route::get('/callback', function (Request $request) {

    $client = new GuzzleHttp\Client;

    $response = $client->post('http://laravel-passport-vue.int/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 4,
            'client_secret' => '6rFBfNKfDnXIMfOqpYVgVEi4m0sSluBW2Vn0JMaB',
            'redirect_uri' => 'http://laravel-passport-vue-client.int/callback',
            'code' => $request->code
        ]
    ]);

    return json_decode((string) $response->getBody(), true);

});