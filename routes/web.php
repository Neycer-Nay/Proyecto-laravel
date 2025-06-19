<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DetallesVentas;
use App\Http\Controllers\Ventas;
use App\Http\Controllers\Productos;
use App\Http\Controllers\Usuarios;
use App\Http\Controllers\Inventario;
use App\Http\Controllers\Reportes;
use App\Http\Controllers\Cotizaciones;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\ClienteController;    


// Crear un usuario administrador, solo usar una vez
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logear', [AuthController::class, 'logear'])->name('logear');


Route::middleware("auth")->group(function () {
    Route::get('/home', [Dashboard::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});



Route::prefix('clientes')->middleware('auth')->group(function () {
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('/{id}', [ClienteController::class, 'show'])->name('clientes.show');
    Route::get('/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
});

Route::prefix('recepciones')->middleware('auth')->group(function () {
    Route::get('/', [RecepcionController::class, 'index'])->name('recepciones.index');
    Route::get('/create', [RecepcionController::class, 'create'])->name('recepciones.create');
    Route::post('/', [RecepcionController::class, 'store'])->name('recepciones.store');
    Route::get('/{id}', [RecepcionController::class, 'show'])->name('recepciones.show');
    Route::get('/{id}/edit', [RecepcionController::class, 'edit'])->name('recepciones.edit');
    Route::put('/{id}', [RecepcionController::class, 'update'])->name('recepciones.update');
    Route::delete('/{id}', [RecepcionController::class, 'destroy'])->name('recepciones.destroy');
    Route::get('/{recepcion}/pdf', [RecepcionController::class, 'generarPDF'])->name('recepciones.pdf');

});


Route::prefix('ventas')->middleware('auth')->group(function () {
    Route::get('/nueva-venta', [Ventas::class, 'index'])->name('ventas-nuevas');
    Route::get('/create', [Ventas::class, 'create'])->name('ventas.create');
    Route::post('/', [Ventas::class, 'store'])->name('ventas.store');
    Route::get('/{id}', [Ventas::class, 'show'])->name('ventas.show');
    Route::get('/{id}/edit', [Ventas::class, 'edit'])->name('ventas.edit');
    Route::put('/{id}', [Ventas::class, 'update'])->name('ventas.update');
    Route::delete('/{id}', [Ventas::class, 'destroy'])->name('ventas.destroy');
}); 
Route::prefix('detalles_ventas')->middleware('auth')->group(function () {
    Route::get('/', [DetallesVentas::class, 'index'])->name('detalles_ventas.index');
    Route::get('/create', [DetallesVentas::class, 'create'])->name('detalles_ventas.create');
    Route::post('/', [DetallesVentas::class, 'store'])->name('detalles_ventas.store');
    Route::get('/{id}', [DetallesVentas::class, 'show'])->name('detalles_ventas.show');
    Route::get('/{id}/edit', [DetallesVentas::class, 'edit'])->name('detalles_ventas.edit');
    Route::put('/{id}', [DetallesVentas::class, 'update'])->name('detalles_ventas.update');
    Route::delete('/{id}', [DetallesVentas::class, 'destroy'])->name('detalles_ventas.destroy');
});

Route::prefix('productos')->middleware('auth')->group(function () {
    Route::get('/', [Productos::class, 'index'])->name('productos.index');
    Route::get('/create', [Productos::class, 'create'])->name('productos.create');
    Route::post('/', [Productos::class, 'store'])->name('productos.store');
    Route::get('/{id}', [Productos::class, 'show'])->name('productos.show');
    Route::get('/{id}/edit', [Productos::class, 'edit'])->name('productos.edit');
    Route::put('/{id}', [Productos::class, 'update'])->name('productos.update');
    Route::delete('/{id}', [Productos::class, 'destroy'])->name('productos.destroy');
});
Route::prefix('usuarios')->middleware('auth')->group(function () {
    Route::get('/', [Usuarios::class, 'index'])->name('usuarios.index');
    Route::get('/create', [Usuarios::class, 'create'])->name('usuarios.create');
    Route::post('/', [Usuarios::class, 'store'])->name('usuarios.store');
    Route::get('/{id}', [Usuarios::class, 'show'])->name('usuarios.show');
    Route::get('/{id}/edit', [Usuarios::class, 'edit'])->name('usuarios.edit');
    Route::put('/{id}', [Usuarios::class, 'update'])->name('usuarios.update');
    Route::delete('/{id}', [Usuarios::class, 'destroy'])->name('usuarios.destroy');
});

Route::prefix('inventario')->middleware('auth')->group(function () {
    Route::get('/', [Inventario::class, 'index'])->name('inventario.index');
    Route::get('/create', [Inventario::class, 'create'])->name('inventario.create');
    Route::post('/', [Inventario::class, 'store'])->name('inventario.store');
    Route::get('/{id}', [Inventario::class, 'show'])->name('inventario.show');
    Route::get('/{id}/edit', [Inventario::class, 'edit'])->name('inventario.edit');
    Route::put('/{id}', [Inventario::class, 'update'])->name('inventario.update');
    Route::delete('/{id}', [Inventario::class, 'destroy'])->name('inventario.destroy');
});

Route::prefix('reportes')->middleware('auth')->group(function () {
    Route::get('/', [Reportes::class, 'index'])->name('reportes.index');
    Route::get('/ventas', [Reportes::class, 'ventas'])->name('reportes.ventas');
    Route::get('/clientes', [Reportes::class, 'clientes'])->name('reportes.clientes');
    Route::get('/productos', [Reportes::class, 'productos'])->name('reportes.productos');
    Route::get('/usuarios', [Reportes::class, 'usuarios'])->name('reportes.usuarios');
    Route::get('/inventario', [Reportes::class, 'inventario'])->name('reportes.inventario');
    Route::get('/recepciones', [Reportes::class, 'recepciones'])->name('reportes.recepciones');
    Route::get('/detalles_ventas', [Reportes::class, 'detallesVentas'])->name('reportes.detalles_ventas');
    Route::get('/export', [Reportes::class, 'export'])->name('reportes.export');
    Route::get('/{id}/pdf', [Reportes::class, 'generatePdf'])->name('reportes.pdf');
    Route::get('/{id}/excel', [Reportes::class, 'generateExcel'])->name('reportes.excel');
    Route::get('/{id}/print', [Reportes::class, 'print'])->name('reportes.print');        
    Route::get('/{id}/send-email', [Reportes::class, 'sendEmail'])->name('reportes.send_email');
    Route::get('/{id}/send-sms', [Reportes::class, 'sendSms'])->name('reportes.send_sms');
});

Route::prefix('cotizaciones')->middleware('auth')->group(function () {
    Route::get('/', [Cotizaciones::class, 'index'])->name('cotizaciones.index');
    Route::get('/create', [Cotizaciones::class, 'create'])->name('cotizaciones.create');
    Route::post('/', [Cotizaciones::class, 'store'])->name('cotizaciones.store');
    Route::get('/{id}', [Cotizaciones::class, 'show'])->name('cotizaciones.show');
    Route::get('/{id}/edit', [Cotizaciones::class, 'edit'])->name('cotizaciones.edit');
    Route::put('/{id}', [Cotizaciones::class, 'update'])->name('cotizaciones.update');
    Route::delete('/{id}', [Cotizaciones::class, 'destroy'])->name('cotizaciones.destroy');
});