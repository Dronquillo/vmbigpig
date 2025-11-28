<div>
    <x-card cardTitle='Compras a Provedores ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Compra</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Factura</th>
                <th>Subtotal</th>
                <th>Descuento</th>
                <th>Impuesto</th>
                <th>Total</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($compras as $compra)
                <tr>
                    <td>{{$compra->id}}</td>
                    <td>{{$compra->fecha}}</td>
                    <td>{{$compra->proveedor_id}}</td>
                    <td>{{$compra->numero_factura}}</td>
                    <td>{{$compra->subtotal}}</td>
                    <td>{{$compra->descuento}}</td>
                    <td>{{$compra->iva}}</td>
                    <td>{{$compra->total}}</td>
                    <td>{{$compra->estado}}</td>
                    <td>
                        
                        <a href="{{route('compra.show',$compra)}}" class="btn btn-sm btn-success" title="Ver"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{$compra->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                        <a wire.click="$dispatch('delete',{id: {{$compra->id}}, eventName:'destroyFarms'})" class="btn btn-sm btn-danger" title="Eliminar"><i class="far fa-trash-alt"></i></a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$compras->links()}}
        </x-slot:cardFooter>

    </x-card>

    @include('livewire.compra.modal')


</div>



