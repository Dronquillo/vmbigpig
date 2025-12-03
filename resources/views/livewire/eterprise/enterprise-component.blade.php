<div>
    <x-card cardTitle='Gestion Empresa ({{$this->totalRegistros}})' >
        <x-slot:cardTools>  
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i>  Crear Empresa</a>
        </x-slot>
        
        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>RUC</th>
                <th>Nombres</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($enterprises as $enterprise)
                <tr>
                    <td>{{$enterprise->id}}</td>
                    <td>{{$enterprise->ruc}}</td>
                    <td>{{$enterprise->nombre}}</td>
                    <td>{{$enterprise->direccion}}</td>
                    <td>{{$enterprise->telefono}}</td>
                    <td>{{$enterprise->correo}}</td>
                    <td>
                        <a href="#" wire:click='edit({{$enterprise->id}})' class="btn btn-sm btn-info" title="Editar"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No hay registros</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{$enterprises->links()}}
        </x-slot:cardFooter>

    </x-card>

    <x-modal modalId="modalEnterprise" modalTitle="Empresas">
        <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="name">RUC: </label>
                    <input wire:model='ruc' type="text" class="form-control" placeholder="RUC de la Empresa" id="ruc">
                    @error('ruc') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group col-12">
                    <label for="name">Nombre: </label>
                    <input wire:model='nombre' type="text" class="form-control" placeholder="Nombre de la Empresa" id="name">
                    @error('nombre') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-12">
                    <label for="direccion">Direccion: </label>
                    <input wire:model='direccion' type="text" class="form-control" placeholder="Direccion de la Empresa" id="direccion">
                    @error('direccion') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-12">
                    <label for="telefono">Telefono: </label>
                    <input wire:model='telefono' type="text" class="form-control" placeholder="Telefono de la Empresa" id="telefono">
                    @error('telefono') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-12">
                    <label for="correo">Correo: </label>
                    <input wire:model='correo' type="text" class="form-control" placeholder="Correo de la Empresa" id="correo">
                    @error('correo') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-md-12">
                    <label for="estado">Estado: </label>
                    <select wire:model='estado' class='form-control' id="estado">
                        <option value="">--Seleccione--</option>
                        <option value="Actvo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>   
                    @error('estado') 
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror

                </div>                
                
            </div>

            <button class="btn btn-primary float-right">{{$Id==0 ? "Guardar Empresa" : "Editar Empresa"}}</button>

        </form>

    </x-modal>

</div>
