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
use App\Livewire\Eterprise\EnterpriseComponent;
use App\Livewire\Eterprise\EnterpriseShow;

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

Route::get('/', PorcinoDashboard::class)->name('porcino.dashboard')->middleware(['auth']);

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function(){

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
    Route::get('/engorde', LoteSelector::class)->name('growth.selector');
    Route::get('/bienestar', WelfareChecksPanel::class)->name('welfare.panel');
    Route::get('/feeding-report', FeedingReport::class)->name('feeding.report')->middleware(['auth']);

    Route::get('/granjas', FarmComponent::class)->name('farms');
    Route::get('/lotes', LotComponent::class)->name('lots');
    Route::get('/galpones', BarnComponent::class)->name('barns');

    Route::get('/feeding', \App\Livewire\Feeding\FeedingDashboardComponent::class)->name('feeding');

        // Route::get('/plans', FeedingPlanComponent::class)->name('plans'); 
        // Route::get('/events', FeedingEventComponent::class)->name('events'); 
        // Route::get('/formulas', FormulaComponent::class)->name('formulas');
        // Route::get('/weights', WeightRecordComponent::class)->name('weights');
        
    Route::get('/alertas', AlertsIndex::class)->name('alerts');

    Route::get('/welfare', WelfareComponent::class)->name('welfare'); 
 
    Route::get('/partos', PartoComponent::class)->name('partos'); 
    Route::get('/partos/{id}', PartoShowComponent::class)->name('partos.show');
   
    Route::get('/categoria-personals', CategoriaPersonalComponent::class)->name('categoria-personals');
    Route::get('/personals', PersonalComponent::class)->name('personals');

});
