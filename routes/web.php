<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'AuthLogin']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Route::get('/user', function () {
    //     return view('user');
    // })->name('users');

    // Route::get('/role', function () {
    //     return view('role');
    // })->name('roles');

// Route to display all books
Route::get('/livre', [BookController::class, 'index'])->name('book.index');

// Route to store a new book
Route::post('/book', [BookController::class, 'store'])->name('book.store');

// Route to update an existing book
Route::put('/book/{book}', [BookController::class, 'update'])->name('book.update');

// Route to delete a book
Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    
    Route::get('/outil', function () {
        return view('outil');
    })->name('outils');

    Route::get('/client', function () {
        return view('client');
    })->name('clients');

    Route::get('/commande', function () {
        return view('commande');
    })->name('commandes');

    Route::get('/permission', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/permission', [PermissionController::class, 'store'])->name('addPermission');
    Route::put('/permission/{permission}', [PermissionController::class, 'update'])->name('updatePermission');
    Route::delete('/permission/{permission}', [PermissionController::class, 'destroy'])->name('deletePermission');
    
    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::post('/role', [RoleController::class, 'store'])->name('addRole');
    Route::get('role/edit/{role}', [RoleController::class, 'edit'])->name('editRole');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('deleteRole');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('updateRole');

});

Route::get('/', function () {
    return redirect()->route('home');
});






// Route to display all users
Route::get('/user', [UserController::class, 'index'])->name('userIndex');

// Route to store the newly created user
Route::post('/user', [UserController::class, 'store'])->name('userStore');

// Route to update the user
Route::put('/user/{user}', [UserController::class, 'update'])->name('userUpdate');

// Route to delete the user
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('userDestroy');