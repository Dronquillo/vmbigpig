<?php

use App\Livewire\Category\CategoryComponent;
use App\Livewire\Category\CategoryShow;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\ProductShow;
use App\Livewire\Providers\ProvidersComponent;
use App\Livewire\Providers\ProvidersShow;
use App\Livewire\Categoact\CategoactComponent;
use App\Livewire\Categoact\CategoactShow;
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

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/inicio', Inicio::class)->name('inicio');

Route::get('/categorias', CategoryComponent::class)->name('categories');
Route::get('/categorias/show/{category}', CategoryShow::class)->name('categories.show');

Route::get('/productos', ProductComponent::class)->name('products');
Route::get('/productos/show/{product}', ProductShow::class)->name('products.show');

Route::get('/proveedores', ProvidersComponent::class)->name('providers');
Route::get('/proveedores/show/{provider}', ProvidersShow::class)->name('providers.show');

Route::get('/categoact', CategoactComponent::class)->name('categoact');
Route::get('/categoact/show/{categoact}', CategoactShow::class)->name('categoact.show');

Route::get('/empresas', EnterpriseComponent::class)->name('enterprise');
Route::get('/empresas/show/{enterprise}', EnterpriseShow::class)->name('eterprise.show');

Route::get('/medidas', MeasurementComponent::class)->name('measurement');
Route::get('/medidas/show/{measurement}', MeasurementShow::class)->name('measurement.show');

Route::get('/farms', FarmComponent::class)->name('farms');
Route::get('/farms/show/{farm}', FarmsShow::class)->name('farms.show');

Route::get('/usuarios', UserComponent::class)->name('users');
Route::get('/usuarios/show/{user}', UserShow::class)->name('users.show');
