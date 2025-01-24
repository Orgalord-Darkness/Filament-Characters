<?php

use Illuminate\Support\Facades\Route;

Route::get('/accueil', function () {
    return view('welcome');
});
