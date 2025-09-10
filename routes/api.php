<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubscriptionController;

// Resource rute (REST)
Route::apiResource('books', BookController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('subscriptions', SubscriptionController::class);

// Primer još 2 API rute koje će ti trebati kasnije (filtriranje/paginacija su već u index):
Route::get('categories/{category}/books', function (\App\Models\Category $category) {
    return response()->json($category->books()->with('category')->paginate(10));
});

// Health-check / ping ruta (lako se testira u Postman-u)
Route::get('ping', fn () => response()->json(['status' => 'ok']));