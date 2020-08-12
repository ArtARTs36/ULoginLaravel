<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('token', 'UserController@auth');
});
