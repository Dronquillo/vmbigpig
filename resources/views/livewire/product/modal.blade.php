    <x-modal modalId="modalProduct" modalTitle="Productos" modalSize="modal-lg">
        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
            <div class="form-row">

                <div class="form-group col-md-7">
                    <label for="name">Nombre: </label>
                    <input wire:model='nombre' type="text" class="form-control" placeholder="Nombre del Producto" id="name">
                    @error('nombre') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
    
                </div>

                <div class="form-group col-md-5">
                    <label for="categoria_id">Categoria: </label>
                    
                    <select wire:model='categoria_id' class='form-control'>
                        <option value="">--Seleccione--</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->nombre}}</option>
                        @endforeach
                    </select>

                    @error('categoria_id') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>      
                
                <div class="form-group col-md-12">
                    <label for="descripcion">Descripcion: </label>
                    <input wire:model='descripcion' type="text" class="form-control" placeholder="Descripcion del Producto" id="descripcion" rows="3">
                    @error('descripcion') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>                

                <div class="form-group col-md-4">
                    <label for="codigo_barras">Codigo de barras: </label>
                    <input wire:model='codigo_barras' type="text" class="form-control" placeholder="Codigo de barras del Producto" id="codigo_barras" rows="3">
                    @error('codigo_barras') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>

                <div class="form-group col-md-4">
                    <label for="costo">Costo Compra: </label>
                    <input wire:model='costo' type="number" min="0" step="any" class="form-control" placeholder="Costo del Producto" id="costo">
                    @error('costo') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 
                                
                <div class="form-group col-md-4">
                    <label for="precio">Precio Venta: </label>
                    <input wire:model='precio' type="number" min="0" step="any" class="form-control" placeholder="Precio del Producto" id="precio">
                    @error('precio') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-4">
                    <label for="fecha_vencimiento">Fecha Vence: </label>
                    <input wire:model='fecha_vencimiento' type="date" class="form-control" id="fecha_vencimiento">
                    @error('fecha_vencimiento') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-4">
                    <label for="stock">Stock: </label>
                    <input wire:model='stock' type="number" min="0"  step="any" class="form-control" placeholder="Stock del Producto" id="stock">
                    @error('stock') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-4">
                    <label for="stock_minimo">Stock Minimo: </label>
                    <input wire:model='stock_minimo' type="number" min="0" step="any" class="form-control" placeholder="Stock minimo del Producto" id="stock_minimo">
                    @error('stock_minimo') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-6">
                    <div class="icheck-primary">
                        <input wire:model='con_iva' type="checkbox" id="con_iva">
                        <label for="con_iva">Tiene IVA?</label>
                    </div>
                    @error('con_iva') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror                    
                </div>

                <div class="form-group col-md-6">
                    <label for="estado">Estado: </label>
                    <select wire:model='estado' class='form-control' id="estado">
                        <option value="">--Seleccione--</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>   
                    @error('estado') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>
               
                <div class="form-group col-md-6">
                    <label for="imagen">Imagen: </label>
                    <input wire:model='imagen' type="file" class="form-control" id="imagen" accept="image/">
                    @error('imagen') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    @if ($this->imagen)
                        <img src="{{$imagen->temporaryUrl()}}" class="rounded float-right" width="200">
                    @endif
                </div>

            </div>

            <button wire:loading.attr="disabled" class="btn btn-primary float-right">{{$Id==0 ? "Guardar Producto" : "Editar Producto"}}</button>

        </form>

    </x-modal>

