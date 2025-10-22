<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});

Route::get('/newUser', function () {
    return view('nuevoUsuario');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/punto_Deventa', function () {
    return view('puntoDeVenta');
});

Route::get('/gestionDeClientes', function () {
    return view('gestionDeClientes');
});

Route::get('/gestion_inventario', function () {
    return view('gestionInventario');
});