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
        Route::get('bancos', 'BancosController@index');


    });
});


Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Clientes'], function () {
        Route::post('cliente', 'ClientesController@create');
        Route::get('cliente', 'ClientesController@getCliente');
        Route::post('cliente/perfil', 'ClientesController@imagemCliente');
        Route::put('cliente/{id}', 'ClientesController@update');
        Route::post('cliente/contabancaria', 'ContaBancariaController@create');
        Route::get('cliente/buscarid/{id}', 'ClientesController@obterCliente');
        Route::get('cliente/{tipo}', 'ClientesController@index');
        Route::get('cliente/buscarPorParent/{id}', 'ClientesController@buscarPorParent');
        Route::post('ativa_cliente', 'ClientesController@ativaCliente');
        Route::get('relatorios', 'ClientesController@getRelatorioClientes');
        Route::get('relatorios/analistas', 'MetaClienteController@index');
        Route::post('cliente/documentos', 'DocumentosClientesController@create');
        Route::get('cliente/documentos/{id}', 'DocumentosClientesController@listDocumentos');
    });
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Produtos'], function () {
        Route::post('produto', 'ContratoMutuoController@create');
        Route::get('produto', 'ContratoMutuoController@listProdutos');
        Route::get('produto/cliente', 'ContratoMutuoController@contratosClientesLogado');
        Route::get('produto/{id}', 'ContratoMutuoController@listProdutosCliente');
        Route::put('produto/{id}', 'ContratoMutuoController@ativarContrato');


    });
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'Relatorios'], function () {
        Route::get('relatorio/mensal', 'RelatorioMensalController@index');
        Route::post('relatorio/mensal/{id}', 'RelatorioMensalController@atualizarStatus');
        Route::get('relatorio/mensal/user', 'RelatorioMensalController@indexAuth');
    });
});

Route::group(['namespace' => 'Produtos'], function () {
    Route::get('produto/pdf/{id}', 'ContratoMutuoController@gerarPdf');
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'bancas'], function () {
        Route::post('banca', 'BancasController@create');
        Route::post('banca/trader', 'BancasController@createBancaTrader');
        Route::get('traders', 'BancasController@listTrader');
    });
});


Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'fornecedores'], function () {
        Route::get('fornecedor', 'FornecedoresController@index');
        Route::post('fornecedor', 'FornecedoresController@create');
        Route::put('fornecedor/{id}', 'FornecedoresController@update');
        Route::post('fornecedor/{id}', 'FornecedoresController@destroy');
    });
});

Route::group(['middleware' => ['jwt', 'jwt.auth']], function () {
    Route::group(['namespace' => 'financeiro'], function () {
        Route::get('conta', 'ContasController@index');
        Route::post('conta', 'ContasController@create');
        Route::post('conta/update/{id}', 'ContasController@update');
        Route::post('conta/{id}', 'ContasController@destroy');
    });
});