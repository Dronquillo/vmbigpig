    <x-modal modalId="modalFarms" modalTitle="Cerdos" modalSize="modal-lg">
        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
            <div class="form-row">

                <div class="form-group col-md-5">
                    <label for="codigo">Codigo: </label>
                    <input wire:model='codigo' type="text" class="form-control" placeholder="Codigo del Cerdo" id="codigo">
                    @error('codigo') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-7">
                    <label for="name">Nombre: </label>
                    <input wire:model='nombre' type="text" class="form-control" placeholder="Nombre del Cerdo" id="name">
                    @error('nombre') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="fecha_nacemiento">Fecha nace: </label>
                    <input wire:model='fecha_nacemiento' type="date" class="form-control" placeholder="Fecha Nacimiento" id="fecha_nacemiento">                    

                    @error('fecha_nacemiento') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>      

                <div class="form-group col-md-3">
                    <label for="hora_nacimiento">Hora nace: </label>
                    <input wire:model='hora_nacimiento' type="text" class="form-control" placeholder="Hora nace" id="hora_nacimiento">
                    @error('hora_nacimiento') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-3">
                    <label for="numero_camada">Camada: </label>
                    <input wire:model='numero_camada' type="number" class="form-control" placeholder="# de camada" id="numero_camada">
                    @error('numero_camada') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div> 

                <div class="form-group col-md-3">
                    <label for="categoria_id">Categoria: </label>
                    <select wire:model='categoria_id' class='form-control'>
                        <option value="">--Seleccione--</option>
                        @foreach($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>                    
                    @error('categoria_id') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div> 



                <div class="form-group col-md-3">
                    <label for="raza">Raza: </label>
                    <select wire:model='raza' class='form-control' id="raza">
                        <option value="">--Seleccione--</option>
                        <option value="Blanca">Blanca</option>
                        <option value="Negra">Negra</option>
                        <option value="Roja">Roja</option>
                    </select>                    

                    @error('raza') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>    

                <div class="form-group col-md-3">
                    <label for="genero">Genero: </label>
                    <select wire:model='genero' class='form-control' id="genero">
                        <option value="">--Seleccione--</option>
                        <option value="Hembra">Hembra</option>
                        <option value="Macho">Macho</option>
                    </select> 

                    @error('genero') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="peso">Peso: </label>
                    <input wire:model='peso' type="text" class="form-control" placeholder="Peso" id="peso">
                    @error('peso') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="medida_id">Medida: </label>
                    <select wire:model='medida_id' class='form-control'>
                        <option value="">--Seleccione--</option>
                        @foreach($medidas as $medida)
                            <option value="{{$medida->id}}">{{$medida->nombre}}</option>
                        @endforeach
                    </select>                    
                    @error('medida_id') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>              

                <div class="form-group col-md-12">
                    <label for="estado_salud">Descripcion: </label>
                    <input wire:model='estado_salud' type="text" class="form-control" placeholder="Descripcion " id="estado_salud" rows="3">
                    @error('estado_salud') 
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

                <div class="form-group col-md-5">
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

            <button class="btn btn-primary float-right">{{$Id==0 ? "Guardar Cerdo" : "Editar Cerdo"}}</button>

        </form>

    </x-modal>