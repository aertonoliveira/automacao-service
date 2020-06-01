<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'Auth'], function () {

    Route::post('auth/login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::post('auth/register', ['as' => 'register', 'uses' => 'RegisterController@register']);
    // Send reset password mail
    Route::post('auth/recovery', 'ForgotPasswordController@sendPasswordResetLink');
    // handle reset password form process
    Route::post('auth/reset', 'ResetPasswordController@callResetPassword');
    // handle reset password form process
    Route::get('auth/verify', 'VerifyAccountController@verify');

});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Profile'], function () {
        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);
        Route::put('profile', ['as' => 'profile', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('auth/logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);
    });

});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Profile'], function () {
        Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@me']);
        Route::put('profile', ['as' => 'profile', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile', 'uses' => 'ProfileController@updatePassword']);
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('auth/logout', ['as' => 'logout', 'uses' => 'LogoutController@logout']);
    });

});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'API'], function () {
        Route::get('regras', 'PermissaoController@indexRegras');
        Route::post('regras', 'PermissaoController@addRegras');
        Route::get('permissao', 'PermissaoController@indexPermissao');
        Route::post('permissao', 'PermissaoController@addPermissao');
        Route::post('menu', 'MenuController@create');
        Route::get('menu', 'MenuController@index');

    });
});


Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Clientes'], function () {
        Route::post('cliente', 'ClientesController@create');
        Route::get('cliente/{tipo}', 'ClientesController@index');
        Route::get('cliente/buscarPorParent/{id}', 'ClientesController@buscarPorParent');
        Route::patch('ativa_cliente', 'ClientesController@ativaCliente');
        Route::patch('cliente/saudo', 'ClientesController@ativaCliente');
    });
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Produtos'], function () {
        Route::post('produto', 'ContratoMutuoController@create');
    });
});





