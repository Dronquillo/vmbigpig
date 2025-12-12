<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Inicio;

// Category
use App\Livewire\Category\CategoryComponent;
use App\Livewire\Category\CategoryShow;

// Product
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductShow;

// Providers
use App\Livewire\Providers\ProvidersComponent;
use App\Livewire\Providers\ProvidersShow;

// Categoact (categoría de activos)
use App\Livewire\Categoact\CategoactComponent;
use App\Livewire\Categoact\CategoactShow;

// Compras
use App\Livewire\Compra\CompraComponent;
use App\Livewire\Compra\CompraShow;

// Enterprise (typo corregido en namespace)
// use App\Livewire\Eterprise\EnterpriseComponent as EterpriseComponent; // si tu carpeta se llama Eterprise
// use App\Livewire\Eterprise\EnterpriseShow as EterpriseShow;
use App\Livewire\Eterprise\EnterpriseComponent;
use App\Livewire\Eterprise\EnterpriseShow;
// o idealmente corrige a:
// use App\Livewire\Enterprise\EnterpriseComponent; 
// use App\Livewire\Enterprise\EnterpriseShow;

// Measurement
use App\Livewire\Measurement\MeasurementComponent;
use App\Livewire\Measurement\MeasurementShow;

// Farms (typo LIvewire → Livewire)
use App\Livewire\Farms\FarmComponent;
use App\Livewire\Farms\FarmsShow;

// User (typo LIvewire → Livewire)
use App\Livewire\User\UserComponent;
use App\Livewire\User\UserShow;

// Client
use App\Livewire\Client\ClientComponent;

// // NUEVO: Gestión Porcina (Feeding/Growth/Welfare)
use App\Livewire\Feeding\FeedingDashboard;
use App\Livewire\Feeding\FeedInventoryManager;
//use App\Livewire\Growth\LotWeightsPanel;
use App\Livewire\Growth\LoteSelector;
use App\Livewire\Welfare\WelfareChecksPanel;

use App\Livewire\Porcino\PorcinoDashboard;
use App\Livewire\Feeding\FeedingReport;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', PorcinoDashboard::class)->name('home')->middleware(['auth']);

Route::middleware(['auth'])->group(function(){

    //Route::get('/inicio', Inicio::class)->name('inicio');
    Route::get('/inicio', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

    // Categorías
    Route::get('/categorias', CategoryComponent::class)->name('categories');
    Route::get('/categorias/show/{category}', CategoryShow::class)->name('categories.show');

    // Productos
    Route::get('/productos', ProductComponent::class)->name('products');
    Route::get('/productos/show/{product}', ProductShow::class)->name('products.show');

    // Proveedores
    Route::get('/proveedores', ProvidersComponent::class)->name('providers');
    Route::get('/proveedores/show/{provider}', ProvidersShow::class)->name('providers.show');

    // Compras
    Route::get('/compras', CompraComponent::class)->name('compras');
    Route::get('/compras/show/{id}', CompraShow::class)->name('compra.show');

    // Categoría de activos
    Route::get('/categoact', CategoactComponent::class)->name('categoact');
    Route::get('/categoact/show/{categoact}', CategoactShow::class)->name('categoact.show');

    // Empresas de activos (ajusta según tu carpeta real)
    Route::get('/empresas', EnterpriseComponent::class)->name('enterprise');
    Route::get('/empresas/show/{enterprise}', EnterpriseShow::class)->name('enterprise.show');

    // Medidas
    Route::get('/medidas', MeasurementComponent::class)->name('measurement');
    Route::get('/medidas/show/{measurement}', MeasurementShow::class)->name('measurement.show');

    // Activos vivos cerdos (Farms)
    Route::get('/farms', FarmComponent::class)->name('farms');
    Route::get('/farms/show/{farm}', FarmsShow::class)->name('farms.show');

    // Usuarios
    Route::get('/usuarios', UserComponent::class)->name('users');
    Route::get('/usuarios/show/{user}', UserShow::class)->name('user.show');

    // Clientes
    Route::get('/clientes', ClientComponent::class)->name('clients');

    // // NUEVO: Gestión Porcina
    Route::get('/alimentacion', FeedingDashboard::class)->name('feeding.dashboard');
    Route::get('/inventario-alimentos', FeedInventoryManager::class)->name('feeding.inventory');
    //Route::get('/engorde/{lotId}', LotWeightsPanel::class)->name('growth.weights');
    Route::get('/engorde', LoteSelector::class)->name('growth.selector');
    Route::get('/bienestar', WelfareChecksPanel::class)->name('welfare.panel');

    Route::get('/porcino-dashboard', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

    Route::get('/feeding-report', FeedingReport::class)->name('feeding.report')->middleware(['auth']);


});



// use App\Livewire\Category\CategoryComponent;
// use App\Livewire\Category\CategoryShow;
// use App\Livewire\Product\ProductComponent;
// use App\Livewire\Product\ProductShow;
// use App\Livewire\Providers\ProvidersComponent;
// use App\Livewire\Providers\ProvidersShow;
// use App\Livewire\Categoact\CategoactComponent;
// use App\Livewire\Categoact\CategoactShow;
// use App\Livewire\Compra\CompraComponent;
// use App\Livewire\Compra\CompraShow;
// use App\Livewire\Eterprise\EnterpriseComponent;
// use App\Livewire\Eterprise\EnterpriseShow;
// use App\Livewire\Measurement\MeasurementComponent;
// use App\Livewire\Measurement\MeasurementShow;
// use App\Livewire\Farms\FarmComponent;
// use App\Livewire\Farms\FarmsShow;
// use App\Livewire\User\UserComponent;
// use App\Livewire\User\UserShow;
// use App\Livewire\Client\ClientComponent;
// use Illuminate\Support\Facades\Route;
// use App\Livewire\Home\Inicio;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes(['register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('/inicio', Inicio::class)->name('inicio')->middleware(['auth']);

// Route::get('/categorias', CategoryComponent::class)->name('categories')->middleware(['auth']);
// Route::get('/categorias/show/{category}', CategoryShow::class)->name('categories.show')->middleware(['auth']);

// Route::get('/productos', ProductComponent::class)->name('products')->middleware(['auth']);
// Route::get('/productos/show/{product}', ProductShow::class)->name('products.show')->middleware(['auth']);

// Route::get('/proveedores', ProvidersComponent::class)->name('providers')->middleware(['auth']);
// Route::get('/proveedores/show/{provider}', ProvidersShow::class)->name('providers.show')->middleware(['auth']);

// Route::get('/categoact', CategoactComponent::class)->name('categoact')->middleware(['auth']);
// Route::get('/categoact/show/{categoact}', CategoactShow::class)->name('categoact.show')->middleware(['auth']);

// Route::get('/empresas', EnterpriseComponent::class)->name('enterprise')->middleware(['auth']);
// Route::get('/empresas/show/{enterprise}', EnterpriseShow::class)->name('eterprise.show')->middleware(['auth']);

// Route::get('/medidas', MeasurementComponent::class)->name('measurement')->middleware(['auth']);
// Route::get('/medidas/show/{measurement}', MeasurementShow::class)->name('measurement.show')->middleware(['auth']);

// Route::get('/farms', FarmComponent::class)->name('farms')->middleware(['auth']);
// Route::get('/farms/show/{farm}', FarmsShow::class)->name('farms.show')->middleware(['auth']);

// Route::get('/usuarios', UserComponent::class)->name('users')->middleware(['auth']);
// Route::get('/usuarios/show/{user}', UserShow::class)->name('user.show')->middleware(['auth']);

// Route::get('/compras', CompraComponent::class)->name('compras')->middleware(['auth']);
// Route::get('/compras/show/{id}', CompraShow::class)->name('compra.show')->middleware(['auth']);

// Route::get('/clientes', ClientComponent::class)->name('clients')->middleware(['auth']);


