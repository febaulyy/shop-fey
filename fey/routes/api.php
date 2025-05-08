<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum'); ||bawaan sini

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); //punya bu wiwit
