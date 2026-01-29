<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Route for searching customers in Elasticsearch
Route::get('customers/search', [CustomerController::class, 'search']);

// Standard CRUD routes (index, store, show, update, destroy)
Route::apiResource('customers', CustomerController::class);