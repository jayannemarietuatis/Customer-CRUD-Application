<?php
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

//will automatically make routes for index, store, show, update, and detstroy
Route::apiResource('customers', CustomerController::class);