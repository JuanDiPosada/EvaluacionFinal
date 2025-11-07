<?php

use App\Http\Controllers\ORMController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::get('/relaciones',[ORMController::class,'testAllRelations']);

Route::apiResource('role', RoleController::class);
