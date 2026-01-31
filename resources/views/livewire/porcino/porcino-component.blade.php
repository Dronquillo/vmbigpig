<div>
    <x-card cardTitle='Gestion de Cerdos ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Cerdo</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Lote</th>
                <th>Codigo</th>
                <th>Nombres</th>
                <th>Fecha Nace</th>
                <th>Hora Nace</th>
                <th># Camada</th>
                <th>Raza</th>
                <th>Genero</th>
                <th>Peso Kg</th>
                <th>Empresa</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($activovivos as $activovivo)
                <tr>
                    <td>{{$activovivo->id}}</td>
                    <td>{{$activovivo->lot_id}}</td>
                    <td>{{$activovivo->codigo}}</td>
                    <td>{{$activovivo->nombre}}</td>
                    <td>{{$activovivo->fecha_nacimiento}}</td>
                    <td>{{$activovivo->hora_nacimiento}}</td>
                    <td>{{$activovivo->numero_camada}}</td>
                    <td>{{$activovivo->raza}}</td>
                    <td>{{$activovivo->genero}}</td>
                    <td>{{$activovivo->peso}}</td>
                    <td>{{$activovivo->empresa_id}}</td>
                    <td>{{$activovivo->estado}}</td>
                    <td>
                        <a href="#" wire:click='edit({{$activovivo->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$activovivos->links()}}
        </x-slot:cardFooter>

    </x-card>

    @include('livewire.porcino.modal')


</div>
