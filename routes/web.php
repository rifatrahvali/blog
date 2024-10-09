<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth')->group(function () {
    // admin/
    Route::get('/', function () {
        return view('admin.index');
    })->name("admin.index");
    // admin/articles/
    Route::get('articles', [ArticleController::class, 'index'])->name('article.index');
    Route::get('articles/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('articles/create', [ArticleController::class, 'store'])->name('article.store');
    Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('article.edit');
    Route::post('articles/{id}/edit', [ArticleController::class, 'update']);
    Route::post('article/change-status', [CategoryController::class, 'changeStatus'])->name('article.changeStatus');
    
    
    Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('categories/create', [CategoryController::class, 'store']);
    Route::post('categories/change-status', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
    Route::post('categories/change-feature-status', [CategoryController::class, 'changeFeatureStatus'])->name('categories.changeFeatureStatus');
    Route::post('categories/delete', [CategoryController::class, 'delete'])->name('categories.delete');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->whereNumber('id');
    Route::post('categories/{id}/edit', [CategoryController::class, 'update'])->whereNumber('id');


});

Route::get('login', [LoginController::class,'showLogin'])->name('login');
Route::post('login', [LoginController::class,'login']);

Route::post('logout', [LoginController::class,'logout'])->name('logout');

Route::get('register', [LoginController::class,'showRegister'])->name('register');
Route::post('register', [LoginController::class,'register']);



Route::get('/', function () {
    return view('admin.index');
})->name("home");