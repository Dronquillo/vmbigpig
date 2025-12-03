<?php

use App\Livewire\Category\CategoryComponent;
use App\Livewire\Category\CategoryShow;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductShow;
use App\Livewire\Providers\ProvidersComponent;
use App\Livewire\Providers\ProvidersShow;
use App\Livewire\Categoact\CategoactComponent;
use App\Livewire\Categoact\CategoactShow;
use App\Livewire\Compra\CompraComponent;
use App\Livewire\Compra\CompraShow;
use App\Livewire\Eterprise\EnterpriseComponent;
use App\Livewire\Eterprise\EnterpriseShow;
use App\Livewire\Measurement\MeasurementComponent;
use App\Livewire\Measurement\MeasurementShow;
use App\LIvewire\Farms\FarmComponent;
use App\LIvewire\Farms\FarmsShow;
use App\Livewire\User\UserComponent;
use App\LIvewire\User\UserShow;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Inicio;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/inicio', Inicio::class)->name('inicio')->middleware(['auth']);

Route::get('/categorias', CategoryComponent::class)->name('categories')->middleware(['auth']);
Route::get('/categorias/show/{category}', CategoryShow::class)->name('categories.show')->middleware(['auth']);

Route::get('/productos', ProductComponent::class)->name('products')->middleware(['auth']);
Route::get('/productos/show/{product}', ProductShow::class)->name('products.show')->middleware(['auth']);

Route::get('/proveedores', ProvidersComponent::class)->name('providers')->middleware(['auth']);
Route::get('/proveedores/show/{provider}', ProvidersShow::class)->name('providers.show')->middleware(['auth']);

Route::get('/categoact', CategoactComponent::class)->name('categoact')->middleware(['auth']);
Route::get('/categoact/show/{categoact}', CategoactShow::class)->name('categoact.show')->middleware(['auth']);

Route::get('/empresas', EnterpriseComponent::class)->name('enterprise')->middleware(['auth']);
Route::get('/empresas/show/{enterprise}', EnterpriseShow::class)->name('eterprise.show')->middleware(['auth']);

Route::get('/medidas', MeasurementComponent::class)->name('measurement')->middleware(['auth']);
Route::get('/medidas/show/{measurement}', MeasurementShow::class)->name('measurement.show')->middleware(['auth']);

Route::get('/farms', FarmComponent::class)->name('farms')->middleware(['auth']);
Route::get('/farms/show/{farm}', FarmsShow::class)->name('farms.show')->middleware(['auth']);

Route::get('/usuarios', UserComponent::class)->name('users')->middleware(['auth']);
Route::get('/usuarios/show/{user}', UserShow::class)->name('user.show')->middleware(['auth']);

Route::get('/compras', CompraComponent::class)->name('compras')->middleware(['auth']);
Route::get('/compras/show/{id}', CompraShow::class)->name('compra.show')->middleware(['auth']);

