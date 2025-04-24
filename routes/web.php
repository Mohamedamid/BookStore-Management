<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DetailCommandeController;
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

    Route::get('/livre', [BookController::class, 'index'])->middleware('permission:book.view')->name('book.index');

    Route::post('/book', [BookController::class, 'store'])->middleware('permission:book.create')->name('book.store');

    Route::put('/book/{book}', [BookController::class, 'update'])->middleware('permission:book.update')->name('book.update');

    Route::delete('/book/{book}', [BookController::class, 'destroy'])->middleware('permission:book.delete')->name('book.destroy');


    // Route to display all fournitures
    Route::get('/outil', [FournitureController::class, 'index'])->middleware('permission:fourniture.view')->name('fournitures.index');
    // Route to store a new fourniture
    Route::post('/outil', [FournitureController::class, 'store'])->middleware('permission:fourniture.create')->name('fourniture.store');
    // Route to update an existing fourniture
    Route::put('outil/{id}', [FournitureController::class, 'update'])->middleware('permission:fourniture.update')->name('fournitures.update');
    // Route to delete a fourniture
    Route::delete('outil/{id}', [FournitureController::class, 'destroy'])->middleware('permission:fourniture.delete')->name('fournitures.destroy');

    // Route to display all roles
    Route::get('/role', [RoleController::class, 'index'])->middleware('permission:role.view')->name('role');
    // Route to store a new role
    Route::post('/role', [RoleController::class, 'store'])->middleware('permission:role.create')->name('addRole');
    // Route to delete a role
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:role.delete')->name('deleteRole');
    // Route to update an existing role
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:role.update')->name('updateRole');

    // Route to display all users
    Route::get('/user', [UserController::class, 'index'])->middleware('permission:user.view')->name('userIndex');
    // Route to store the newly created user
    Route::post('/user', [UserController::class, 'store'])->middleware('permission:user.create')->name('userStore');
    // Route to update the user
    Route::put('/user/{user}', [UserController::class, 'update'])->middleware('permission:user.update')->name('userUpdate');
    // Route to delete the user
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware('permission:user.delete')->name('userDestroy');

    Route::get('/commande', [CommandeController::class, 'create'])->middleware('permission:commande.create')->name('commandes.create');
    // Route::post('/commande', [CommandeController::class, 'store'])->name('commandes.store');
    Route::post('/commandes', [CommandeController::class, 'store'])->middleware('permission:commande.store');

    // Affiche la liste des clients
    Route::get('/client', [ClientController::class, 'index'])->middleware('permission:client.view')->name('clients.index');
    // Enregistre un nouveau client (formulaire d'ajout)
    Route::post('/clients', [ClientController::class, 'store'])->middleware('permission:user.create')->name('clients.store');
    // Met à jour un client existant
    Route::put('/clients/{client}', [ClientController::class, 'update'])->middleware('permission:user.update')->name('clients.update');
    // Supprime un client
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->middleware('permission:user.delete')->name('clients.destroy');

    // Pour AJAX
    Route::get('/clients/info/{id}', [ClientController::class, 'info']);
    Route::get('/produit/find/{reference}', [ProduitController::class, 'findProduct'])->name('produit.find');

    Route::get('/Detail_commande', [DetailCommandeController::class, 'index'])->middleware('permission:Detail.commande');
    Route::get('/commandes/{id}/details', [CommandeController::class, 'details'])->name('commandes.details');
});






