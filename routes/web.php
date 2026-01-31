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

use App\Livewire\Porcino\PorcinoComponent;
use App\Livewire\Porcino\PorcinoShow;

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

use App\Livewire\Lot\LotComponent;
use App\Livewire\Barn\BarnComponent;

// Feeding (Planes y Eventos) 
use App\Livewire\Feeding\Plans\FeedingPlanComponent; 
use App\Livewire\Feeding\Events\FeedingEventComponent;
// Growth (Pesos) 
use App\Livewire\Growth\Weights\WeightRecordComponent; 
// Welfare (Bienestar) 
use App\Livewire\Welfare\WelfareComponent; 
// Partos 
use App\Livewire\Partos\PartoComponent;
use App\Livewire\Partos\PartoShowComponent;

//Formulas (Feeding)
use App\Livewire\Formula\FormulaComponent;

//Alertas
use App\Livewire\Alerts\AlertsIndex;

use App\Livewire\CategoriaPersonal\CategoriaPersonalComponent;
use App\Livewire\Personal\PersonalComponent;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/home', PorcinoDashboard::class)->name('home')->middleware(['auth']);

Route::middleware(['auth'])->group(function(){

    //Route::get('/inicio', Inicio::class)->name('inicio');
    //Route::get('/inicio', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

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

    // Activos vivos cerdos (pigs)
    Route::get('/pigs', PorcinoComponent::class)->name('pigs');
    Route::get('/pigs/show/{pigs}', PorcinoShow::class)->name('pigs.show');

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

    //Route::get('/porcino-dashboard', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

    Route::get('/feeding-report', FeedingReport::class)->name('feeding.report')->middleware(['auth']);

    Route::get('/granjas', FarmComponent::class)->name('farms');
    Route::get('/lotes', LotComponent::class)->name('lots');
    Route::get('/galpones', BarnComponent::class)->name('barns');

    // Alimentación 
    //Route::prefix('feeding')->name('feeding.')->group(function () { 

        Route::get('/plans', FeedingPlanComponent::class)->name('plans'); 
        Route::get('/events', FeedingEventComponent::class)->name('events'); 
        Route::get('/formulas', FormulaComponent::class)->name('formulas');
        
    //}); 
    //Alertas
    Route::get('/alertas', AlertsIndex::class)->name('alerts');

    // Engorde (Pesos) 
    //Route::prefix('growth')->name('growth.')->group(function () { 
        Route::get('/weights', WeightRecordComponent::class)->name('weights'); 
    //}); 
    // Bienestar 
    //Route::prefix('welfare')->name('welfare.')->group(function () { 
        Route::get('/welfare', WelfareComponent::class)->name('welfare'); 
    //}); 
    // Partos 
    //Route::prefix('partos')->name('partos.')->group(function () { 
        Route::get('/partos', PartoComponent::class)->name('partos'); 
        Route::get('/partos/{id}', PartoShowComponent::class)->name('partos.show');
    //});    
    
    Route::get('/categoria-personals', CategoriaPersonalComponent::class)->name('categoria-personals');
    Route::get('/personals', PersonalComponent::class)->name('personals');


    // Dashboard principal     Route::view('/', 'dashboard')->name('dashboard'); 

    // Alimentación 
    // Route::prefix('feeding')->name('feeding')->group(function () { 
        //Route::get('/plans', [FeedingPlanController::class])->name('plans'); 
        // Route::get('plans/create', [FeedingPlanController::class, 'create'])->name('plans.create'); 
        // Route::post('plans', [FeedingPlanController::class, 'store'])->name('plans.store'); 
        // Route::get('plans/{plan}/edit', [FeedingPlanController::class, 'edit'])->name('plans.edit'); 
        // Route::put('plans/{plan}', [FeedingPlanController::class, 'update'])->name('plans.update'); 
        // Route::delete('plans/{plan}', [FeedingPlanController::class, 'destroy'])->name('plans.destroy'); 

        // Route::get('/events', [FeedingEventController::class])->name('events'); 
        // Route::get('events/create/lot/{lot}', [FeedingEventController::class, 'createFromPlan'])->name('events.createFromPlan'); 
        // Route::post('events', [FeedingEventController::class, 'store'])->name('events.store'); 

    // }); 
        
    // Engorde 
    //Route::prefix('growth')->name('growth')->group(function () { 
        //Route::get('/weights', [WeightRecordController::class])->name('weights'); 
        // Route::get('weights/create', [WeightRecordController::class, 'create'])->name('weights.create'); 
        // Route::post('weights', [WeightRecordController::class, 'store'])->name('weights.store'); 
    //}); 
    
    // Bienestar 
    //Route::prefix('welfare')->name('welfare')->group(function () { 
        //Route::get('/welfare', [WelfareCheckController::class])->name('welfare'); 
        // Route::get('create', [WelfareCheckController::class, 'create'])->name('create'); 
        // Route::post('/', [WelfareCheckController::class, 'store'])->name('store'); 
    //}); 
    
    // Partos 
    //Route::prefix('partos')->name('partos')->group(function () { 
        //Route::get('/partos', [PartoController::class, 'index'])->name('partos'); 
        // Route::get('create', [PartoController::class, 'create'])->name('create'); 
        // Route::post('/', [PartoController::class, 'store'])->name('store'); 
        // Route::get('{parto}', [PartoController::class, 'show'])->name('show'); 
        // Route::post('{parto}/estados', [PartoController::class, 'storeEstado'])->name('estados.store'); 
    //}); 
    
    // // Compras 
    // Route::post('compras/detalles', [CompraDetalleController::class, 'store'])->name('compras.detalles.store');

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


