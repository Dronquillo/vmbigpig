<x-modal modalId="modalCompra" modalTitle="Compra a Proveedor" modalSize="modal-lg">
    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>

        <div class="form-row">

            <div class="form-group col-md-12">
                <label for="fecha">Fecha</label>
                <input type="date" wire:model="fecha" class="form-control">
            </div>

            <div class="form-group col-md-4">
                <label for="proveedor_id">Proveedor: </label>
                <select wire:model='proveedor_id' class='form-control'>
                    @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->ruc.'-'.$proveedor->nombre}}</option>
                    @endforeach
                </select>
                @error('proveedor_id') 
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-8">
                <label for="nombre">Nombre Proveedor: </label>
                <input type="text" class="form-control" value="{{ $nombre }}" readonly>
            </div>

            
            <div class="form-group col-md-4">
                <label for="numero_factura">Número de Factura: </label>
                <input type="text" wire:model="numero_factura" class="form-control" name="numero_factura" id="numero_factura">
                @error('numero_factura')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-5">
                <label for="empresa_id">Empresa: </label>
                
                <select wire:model='empresa_id' class='form-control'>
                    @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                    @endforeach
                </select>
                @error('empresa_id') 
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-3">
                <label for="porc_iva">% IVA: </label>
                <input type="text" wire:model="porc_iva" class="form-control" name="porc_iva" id="porc_iva">
                @error('porc_iva')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>            


            {{-- Detalle --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">Detalle de Productos</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <select wire:model="producto_id" class="form-control">
                                @foreach($productos as $producto)
                                    <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col"><input type="number" wire:model="cantidad" placeholder="Cantidad" class="form-control"></div>
                        <div class="col"><input type="number" wire:model="precio_compra" step="0.01" placeholder="Precio" class="form-control"></div>
                        <div class="col"><input type="numbre" wire:model="porc_ivas" placeholder="% IVA" class="form-control"></div>
                        <div class="col"><input type="number" wire:model="detalle_descuento" step="0.01" placeholder="Descuento" class="form-control"></div>
                        <div class="col">
                            <button type="button" wire:click="addDetalle" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>% IVA</th>
                                <th>Desc.</th>
                                <th>IVA</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $index => $d)
                                <tr>
                                    <td>
                                        <select wire:model="detalles.{{ $index }}.producto_id" class="form-control">
                                            @foreach($productos as $producto)
                                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" wire:model="detalles.{{ $index }}.cantidad" class="form-control"></td>
                                    <td><input type="number" wire:model="detalles.{{ $index }}.precio_compra" step="0.01" class="form-control"></td>
                                    <td><input type="number" wire:model="detalles.{{ $index }}.porc_iva" class="form-control"></td>
                                    <td><input type="number" wire:model="detalles.{{ $index }}.descuento" step="0.01" class="form-control"></td>
                                    <td>{{ $d['iva'] }}</td>
                                    <td>{{ $d['subtotal'] }}</td>
                                    <td>
                                        <button type="button" wire:click="removeDetalle({{ $index }})" class="btn btn-danger btn-sm">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Totales --}}
            <div class="card mb-4 shadow">
                <div class="card-header bg-warning font-weight-bold">Totales</div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col">
                            <span class="badge badge-secondary">Subtotal</span>
                            <h6>{{ number_format($subtotal, 2) }}</h6>
                        </div>
                        <div class="col">
                            <span class="badge badge-danger">Descuento</span>
                            <h6>-{{ number_format($descuento, 2) }}</h6>
                        </div>
                        <div class="col">
                            <span class="badge badge-info">IVA</span>
                            <h6>{{ number_format($iva, 2) }}</h6>
                        </div>
                        <div class="col">
                            <span class="badge badge-success">Total</span>
                            <h5 class="font-weight-bold">{{ number_format($total, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-success float-right">{{$Id==0 ? "Guardar Compra" : "Editar Compra"}}</button>

    </form>

</x-modal>        