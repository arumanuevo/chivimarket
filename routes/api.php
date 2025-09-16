<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');


// Rutas para autenticación con Google
Route::prefix('')->group(function () {
    Route::get('login/google', [SocialAuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Rutas para autenticaci��n con Facebook
Route::get('login/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('facebook/callback', [SocialAuthController::class, 'handleFacebookCallback'])->name('facebook.callback');

// Rutas para autenticaci��n con X (Twitter)
Route::get('login/twitter', [SocialAuthController::class, 'redirectToTwitter'])->name('login.twitter');
Route::get('twitter/callback', [SocialAuthController::class, 'handleTwitterCallback'])->name('twitter.callback');


Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    //Route::get('users', [UserController::class, 'index2']);
    Route::get('negocios/user/{userId}', [NegocioController::class, 'negociosPorUsuario']);
    Route::get('productos/negocio/{negocioId}', [ProductoController::class, 'productosPorNegocio']);

    Route::get('messages/{user}', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::get('pusher-credentials', function () {
        return response()->json([
            'appKey' => env('PUSHER_APP_KEY'),
            'cluster' => env('PUSHER_APP_CLUSTER')
        ]);
    });
    Route::post('pusher/auth', function (Request $request) {
        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name');

        $auth = app('pusher')->socket_auth($channelName, $socketId);

        return response($auth);
    });
});





