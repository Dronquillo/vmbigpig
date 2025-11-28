<x-modal modalId="modalCompra" modalTitle="Compra a Proveedor" modalSize="modal-lg">
    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>

        <div class="form-row">
            <h2 class="mb-4">Registro de Compras 🐖</h2>

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
                            @foreach($detalles as $d)
                                <tr>
                                    <td>{{ $d['producto_id'] }}</td>
                                    <td>{{ $d['cantidad'] }}</td>
                                    <td>{{ $d['precio_compra'] }}</td>
                                    <td>{{ $d['porc_iva']}}</td>
                                    <td>{{ $d['descuento'] }}</td>
                                    <td>{{ $d['iva'] }}</td>
                                    <td>{{ $d['subtotal'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Totales --}}
            <div class="card mb-4">
                <div class="card-header bg-warning">Totales</div>
                <div class="card-body">
                    <p><strong>Subtotal:</strong> {{ $subtotal }}</p>
                    <p><strong>Descuento:</strong> {{ $descuento }}</p>
                    <p><strong>IVA:</strong> {{ $iva }}</p>
                    <p><strong>Total:</strong> {{ $total }}</p>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-success float-right">{{$Id==0 ? "Guardar Compra" : "Editar Compra"}}</button>

    </form>

</x-modal>        