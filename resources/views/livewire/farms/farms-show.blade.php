<x-card cardTitle='Detalles de los Activos Vivos'>
        <x-slot:cardTools>  
            <a href="{{route('farms')}}" class="btn btn-primary">
                <i class="fas fa-arrow-circle-left"></i>  Regresar</a>
        </x-slot>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h2 class="profile-username text-center">{{$cerdos->nombre}}</h2>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item"><b>Prouctos</b><a class="float-right">1,500</a></li>
                            <li class="list-group-item"><b>Artiulos</b><a class="float-right">500</a></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

</x-card>
