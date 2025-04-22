<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FournitureController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'AuthLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Route to display the home page
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Route to display all books
    Route::get('/livre', [BookController::class, 'index'])->name('book.index');
    // Route to store a new book
    Route::post('/book', [BookController::class, 'store'])->name('book.store');
    // Route to update an existing book
    Route::put('/book/{book}', [BookController::class, 'update'])->name('book.update');
    // Route to delete a book
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');

    // Route to display all fournitures
    Route::get('/outil', [FournitureController::class, 'index'])->name('fournitures.index');
    // Route to store a new fourniture
    Route::post('/outil', [FournitureController::class, 'store'])->name('fourniture.store');
    // Route to update an existing fourniture
    Route::put('outil/{id}', [FournitureController::class, 'update'])->name('fournitures.update');
    // Route to delete a fourniture
    Route::delete('outil/{id}', [FournitureController::class, 'destroy'])->name('fournitures.destroy');

    // Route to display all roles
    Route::get('/role', [RoleController::class, 'index'])->name('role');
    // Route to store a new role
    Route::post('/role', [RoleController::class, 'store'])->name('addRole');
    // Route to delete a role
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('deleteRole');
    // Route to update an existing role
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('updateRole');

    // Route to display all users
    Route::get('/user', [UserController::class, 'index'])->name('userIndex');
    // Route to store the newly created user
    Route::post('/user', [UserController::class, 'store'])->name('userStore');
    // Route to update the user
    Route::put('/user/{user}', [UserController::class, 'update'])->name('userUpdate');
    // Route to delete the user
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('userDestroy');

    Route::get('/commande', [CommandeController::class, 'create'])->name('commandes.create');
    // Route::post('/commande', [CommandeController::class, 'store'])->name('commandes.store');
    Route::post('/commandes', [CommandeController::class, 'store']);

    // Pour AJAX
    Route::get('/clients/info/{id}', [ClientController::class, 'info']);


    // Affiche la liste des clients
    Route::get('/client', [ClientController::class, 'index'])->name('clients.index');
    // Enregistre un nouveau client (formulaire d'ajout)
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    // Met à jour un client existant
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    // Supprime un client
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');


    Route::get('/ventes/create', [ProduitController::class, 'create'])->name('ventes.create');
    Route::get('/produit/find/{reference}', [ProduitController::class, 'findProduct'])->name('produit.find');
    Route::post('/ventes', [ProduitController::class, 'store'])->name('ventes.store');

});






