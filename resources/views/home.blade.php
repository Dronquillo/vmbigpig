@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="mb-0">🐖 Panel de Gestión Porcina</h3>
                </div>

                <div class="card-body bg-light">
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h4 class="font-weight-bold">Bienvenido al sistema de control de cuidado y engorde de cerdos</h4>
                        <p class="lead">
                            Aquí podrás monitorear el crecimiento, alimentación y bienestar de tus animales,
                            asegurando un manejo eficiente y responsable de la granja.
                        </p>
                    </div>

                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-white rounded shadow-sm">
                                <h5>🍽️ Alimentación</h5>
                                <p>Registra y controla las raciones diarias para un crecimiento óptimo.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-white rounded shadow-sm">
                                <h5>📈 Engorde</h5>
                                <p>Monitorea el peso y evolución de cada lote de cerdos.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-white rounded shadow-sm">
                                <h5>❤️ Bienestar</h5>
                                <p>Supervisa la salud y condiciones de los animales.</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('inicio') }}" class="btn btn-success btn-lg rounded-pill px-5">
                            Ir a la Página de Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
