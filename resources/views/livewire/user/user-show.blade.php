    <x-card cardTitle='Detalles de Usuario'>
        <x-slot:cardTools>  
            <a href="{{route('users')}}" class="btn btn-primary">
                <i class="fas fa-arrow-circle-left"></i>Regresar</a>
        </x-slot>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <x-image :item="$user" size="250" class="profile-user-img img-fluid img-circle"/>
                        </div>
                        <h2 class="profile-username text-center">{{$user->name}}</h2>
                        <p class="text-muted text-enter">
                            <li class="list-group-item">
                                <b>Perfil</b><a class="float-right">{{$user->admin ? 'ADMINISTRADOR' : 'USUARIO'}}</a></li>
                        </p>
                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                                <b>Email</b><a class="float-right">{{$user->email}}</a></li>

                            <li class="list-group-item">
                                <b>Estado</b><a class="float-right">{{!!$user->activeLabel !!}}</a></li>

                            <li class="list-group-item">
                                <b>Creado</b><a class="float-right">{{$user->created_at}}</a></li>

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
