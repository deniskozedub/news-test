<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\API')->group(function(){
    Route::resource('news',NewsController::class);
    Route::resource('tags',TagsController::class);
});

