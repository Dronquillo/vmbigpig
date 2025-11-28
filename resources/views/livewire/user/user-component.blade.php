<div>
    <x-card cardTitle="Lista de Usuarios ({{$this->totalRegistros}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="create">
                <i class="fas fa-user-plus mr-2"></i> Nuevo Usuario </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <tr>
                    <th class="w-10">ID</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th class="w-20">Acciones</th>
                </tr>
            </x-slot>

            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->admin ? 'Administrador' : 'Vendedor' }}</td>
                    <td>{{ $user->activo ? 'ACTIVO' : 'INACTIVO' }}</td>
                    <td>
                        <a href="{{route('users.show',$users)}}" class="btn btn-success btn-sm" title = "Ver"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{$user->id}})' class="btn btn-primary btn-sm" title="Editar"><i class="far fa-edit"></i></a>
                        <a wire:click="$dispatch('delete',{id: {{$user->id}}, eventName:'destroyUser'})" class="btn btn-danger btn-sm" title="Eliminar"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="8">No hay usuarios registrados.</td>
                </tr>
            @endforelse

        </x-table>
        
        <x-slot:cardFooter>
            {{$users->links()}}
        </x-slot>

    </x-card>

    @include('livewire.user.modal')

</div>
