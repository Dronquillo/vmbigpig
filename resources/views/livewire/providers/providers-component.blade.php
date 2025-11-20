<div>
    <x-card cardTitle='Gestion de Proveedores ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Proveedor</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>RUC</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Contacto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($providers as $provider)
                <tr>
                    <td>{{$provider->id}}</td>
                    <td>{{$provider->ruc}}</td>
                    <td>{{$provider->nombre}}</td>
                    <td>{{$provider->direccion}}</td>
                    <td>{{$provider->telefono}}</td>
                    <td>{{$provider->correo}}</td>
                    <td>{{$provider->contacto}}</td>
                    <td>{{$provider->estado}}</td>
                    <td>
                        
                        <a href="{{route('providers.show',$provider)}}" class="btn btn-sm btn-success" title="Ver"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{$provider->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                        <a wire.click="$dispatch('delete',{id: {{$provider->id}}, eventName:'destroyFarms'})" class="btn btn-sm btn-danger" title="Eliminar"><i class="far fa-trash-alt"></i></a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$providers->links()}}
        </x-slot:cardFooter>

    </x-card>

    @include('livewire.providers.modal')


</div>
