<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('token', 'UserController@auth');
    Route::post('token_redirect', 'UserController@redirectAfterSuccessAuth');
    Route::post('attach_profile', 'UserController@attachProfile');
});
