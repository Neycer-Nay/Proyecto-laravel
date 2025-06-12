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
    Route::get('/create', [\App\Http\Controllers\Ventas::class, 'create'])->name('ventas.create');
    Route::post('/', [\App\Http\Controllers\Ventas::class, 'store'])->name('ventas.store');
    Route::get('/{id}', [\App\Http\Controllers\Ventas::class, 'show'])->name('ventas.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\Ventas::class, 'edit'])->name('ventas.edit');
    Route::put('/{id}', [\App\Http\Controllers\Ventas::class, 'update'])->name('ventas.update');
    Route::delete('/{id}', [\App\Http\Controllers\Ventas::class, 'destroy'])->name('ventas.destroy');
}); 
Route::prefix('detalles_ventas')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\DetallesVentas::class, 'index'])->name('detalles_ventas.index');
    Route::get('/create', [\App\Http\Controllers\DetallesVentas::class, 'create'])->name('detalles_ventas.create');
    Route::post('/', [\App\Http\Controllers\DetallesVentas::class, 'store'])->name('detalles_ventas.store');
    Route::get('/{id}', [\App\Http\Controllers\DetallesVentas::class, 'show'])->name('detalles_ventas.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\DetallesVentas::class, 'edit'])->name('detalles_ventas.edit');
    Route::put('/{id}', [\App\Http\Controllers\DetallesVentas::class, 'update'])->name('detalles_ventas.update');
    Route::delete('/{id}', [\App\Http\Controllers\DetallesVentas::class, 'destroy'])->name('detalles_ventas.destroy');
});

Route::prefix('productos')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Productos::class, 'index'])->name('productos.index');
    Route::get('/create', [\App\Http\Controllers\Productos::class, 'create'])->name('productos.create');
    Route::post('/', [\App\Http\Controllers\Productos::class, 'store'])->name('productos.store');
    Route::get('/{id}', [\App\Http\Controllers\Productos::class, 'show'])->name('productos.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\Productos::class, 'edit'])->name('productos.edit');
    Route::put('/{id}', [\App\Http\Controllers\Productos::class, 'update'])->name('productos.update');
    Route::delete('/{id}', [\App\Http\Controllers\Productos::class, 'destroy'])->name('productos.destroy');
});
Route::prefix('usuarios')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Usuarios::class, 'index'])->name('usuarios.index');
    Route::get('/create', [\App\Http\Controllers\Usuarios::class, 'create'])->name('usuarios.create');
    Route::post('/', [\App\Http\Controllers\Usuarios::class, 'store'])->name('usuarios.store');
    Route::get('/{id}', [\App\Http\Controllers\Usuarios::class, 'show'])->name('usuarios.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\Usuarios::class, 'edit'])->name('usuarios.edit');
    Route::put('/{id}', [\App\Http\Controllers\Usuarios::class, 'update'])->name('usuarios.update');
    Route::delete('/{id}', [\App\Http\Controllers\Usuarios::class, 'destroy'])->name('usuarios.destroy');
});

Route::prefix('inventario')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Inventario::class, 'index'])->name('inventario.index');
    Route::get('/create', [\App\Http\Controllers\Inventario::class, 'create'])->name('inventario.create');
    Route::post('/', [\App\Http\Controllers\Inventario::class, 'store'])->name('inventario.store');
    Route::get('/{id}', [\App\Http\Controllers\Inventario::class, 'show'])->name('inventario.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\Inventario::class, 'edit'])->name('inventario.edit');
    Route::put('/{id}', [\App\Http\Controllers\Inventario::class, 'update'])->name('inventario.update');
    Route::delete('/{id}', [\App\Http\Controllers\Inventario::class, 'destroy'])->name('inventario.destroy');
});

Route::prefix('reportes')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Reportes::class, 'index'])->name('reportes.index');
    Route::get('/ventas', [\App\Http\Controllers\Reportes::class, 'ventas'])->name('reportes.ventas');
    Route::get('/clientes', [\App\Http\Controllers\Reportes::class, 'clientes'])->name('reportes.clientes');
    Route::get('/productos', [\App\Http\Controllers\Reportes::class, 'productos'])->name('reportes.productos');
    Route::get('/usuarios', [\App\Http\Controllers\Reportes::class, 'usuarios'])->name('reportes.usuarios');
    Route::get('/inventario', [\App\Http\Controllers\Reportes::class, 'inventario'])->name('reportes.inventario');
    Route::get('/recepciones', [\App\Http\Controllers\Reportes::class, 'recepciones'])->name('reportes.recepciones');
    Route::get('/detalles_ventas', [\App\Http\Controllers\Reportes::class, 'detallesVentas'])->name('reportes.detalles_ventas');
    Route::get('/export', [\App\Http\Controllers\Reportes::class, 'export'])->name('reportes.export');
    Route::get('/{id}/pdf', [\App\Http\Controllers\Reportes::class, 'generatePdf'])->name('reportes.pdf');
    Route::get('/{id}/excel', [\App\Http\Controllers\Reportes::class, 'generateExcel'])->name('reportes.excel');
    Route::get('/{id}/print', [\App\Http\Controllers\Reportes::class, 'print'])->name('reportes.print');        
    Route::get('/{id}/send-email', [\App\Http\Controllers\Reportes::class, 'sendEmail'])->name('reportes.send_email');
    Route::get('/{id}/send-sms', [\App\Http\Controllers\Reportes::class, 'sendSms'])->name('reportes.send_sms');
});

Route::prefix('cotizaciones')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\Cotizaciones::class, 'index'])->name('cotizaciones.index');
    Route::get('/create', [\App\Http\Controllers\Cotizaciones::class, 'create'])->name('cotizaciones.create');
    Route::post('/', [\App\Http\Controllers\Cotizaciones::class, 'store'])->name('cotizaciones.store');
    Route::get('/{id}', [\App\Http\Controllers\Cotizaciones::class, 'show'])->name('cotizaciones.show');
    Route::get('/{id}/edit', [\App\Http\Controllers\Cotizaciones::class, 'edit'])->name('cotizaciones.edit');
    Route::put('/{id}', [\App\Http\Controllers\Cotizaciones::class, 'update'])->name('cotizaciones.update');
    Route::delete('/{id}', [\App\Http\Controllers\Cotizaciones::class, 'destroy'])->name('cotizaciones.destroy');
});