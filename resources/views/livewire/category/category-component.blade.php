<div>
    <x-card cardTitle='Gestion Categorias ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Categorias</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Nombres</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->nombre}}</td>
                    <td>
                        <a href="{{route('categories.show',$category)}}" class="btn btn-sm btn-success" title="Ver"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{$category->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                        <a wire.click="$dispatch('delete',{id: {{$category->id}}, eventName:'destroyCategory'})" class="btn btn-sm btn-danger" title="Eliminar"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$categories->links()}}
        </x-slot:cardFooter>

    </x-card>

    <x-modal modalId="modalCategory" modalTitle="Categorias">
        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="name">Nombre: </label>
                    <input wire:model='nombre' type="text" class="form-control" placeholder="Nombre de la Categoria" id="name">
                    @error('nombre') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <button class="btn btn-primary float-right">{{$Id==0 ? "Guardar Categoria" : "Editar Gategoria"}}</button>

        </form>

    </x-modal>

</div>
