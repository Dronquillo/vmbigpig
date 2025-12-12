<div>
    <x-card cardTitle="Listado de Clientes ({{$this->totalRegistros}})">

        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Crear Cliente </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Cedula RUC</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th width="3%">...</th>
            </x-slot>

            @forelse($clientes as $client)

                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->cedularuc}}</td>
                    <td>{{$client->nombre}}</td>
                    <td>{{$client->direccion}}</td>
                    <td>{{$client->telefono}}</td>
                    <td>{{$client->correo}}</td>
                    <td>
                        <a href="#" wire:click='edit({{$client->id}})'><i class="fas fa-edit"></i></a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">No hay registros</td>
                </tr>

            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$clientes->links()}}
        </x-slot>

    </x-card>

    @include('livewire.client.modal')


</div>
