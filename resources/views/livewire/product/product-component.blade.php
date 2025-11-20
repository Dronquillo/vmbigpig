<div>
    <x-card cardTitle='Gestion de Productos ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Producto</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Imagen</th>
                <th>Nombres</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoria</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>imagen</td>
                    <td>{{$product->nombre}}</td>
                    <td>{{$product->precio}}</td>
                    <td>{{$product->stock}}</td>
                    <td>{{$product->categoria_id}}</td>
                    <td>{{$product->estado}}</td>
                    <td>
                        <a href="{{route('products.show',$product)}}" class="btn btn-sm btn-success" title="Ver"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{$product->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                        <a wire.click="$dispatch('delete',{id: {{$product->id}}, eventName:'destroyProduct'})" class="btn btn-sm btn-danger" title="Eliminar"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$products->links()}}
        </x-slot:cardFooter>

    </x-card>

    @include('livewire.product.modal')



</div>
