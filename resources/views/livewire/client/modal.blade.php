<x-modal modalId="modalClient" modalTitle="Clientes" modalSize="modal-lg">
        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>   

            <div class="form-row">
                <div class="form-group col-12">
                    <label for="cedularuc">Cédula / RUC: </label>
                    <input wire:model='cedularuc' type="text" class="form-control" placeholder="Cédula o RUC del Cliente" id="cedularuc">
                    @error('cedularuc') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-12">
                    <label for="name">Nombre: </label>
                    <input wire:model='nombre' type="text" class="form-control" placeholder="Nombre del Cliente" id="name">
                    @error('nombre') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="direccion">Direccion: </label>
                    <input wire:model='direccion' type="text" class="form-control" placeholder="Direccion del Cliente" id="direccion">
                    @error('direccion') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="correo">Correo: </label>
                    <input wire:model='correo' type="text" class="form-control" placeholder="Correo" id="corrreo">
                    @error('correo') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">            
                <div class="form-group col-md-6">
                    <label for="telefono">Telefono: </label>
                    <input wire:model='telefono' type="text" class="form-control" placeholder="# de telefono" id="telefono">
                    @error('telefono') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div> 

                <div class="form-group col-md-6">
                    <label for="estado">Estado: </label>
                    <select wire:model='estado' class='form-control' id="estado">
                        <option value="">--Seleccione--</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>   
                    @error('estado') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>
            </div>

            <button class="btn btn-primary float-right">{{$Id==0 ? "Guardar Cliente" : "Editar Cliente"}}</button>

        </form>

    </x-modal>