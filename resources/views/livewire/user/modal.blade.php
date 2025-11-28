<x-modal modalId="modalUser" modalTitle="Usuarios" modalSize="modal-lg">
    <form wire:submit={{$Id==0 ? "store" : "update($Id)"}}>
        <div class="form-row">
            <div class="form-group col-12 col-md-6">
                <label for="name">Nombre</label>
                <input wire:model='name' type="text" id="name" class="form-control" placeholder="Nombre">
                    @error('name') <div class="alert alert-danger w-100 mt-2"> {{$message}} </div> @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="email">Correo electronico</label>
                <input wire:model='email' type="email" id="email" class="form-control" placeholder="Correo electronico">
                    @error('email') <div class="alert alert-danger w-100 mt-2"> {{$message}} </div> @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="password">Clave</label>
                <input wire:model='password' type="password" id="password" class="form-control" placeholder="password">
                    @error('password') <div class="alert alert-danger w-100 mt-2"> {{$message}} </div> @enderror
            </div>
            <div class="form-group col-12 col-md-6">
                <label for="re_password">Confirmar Clave</label>
                <input wire:model='re_password' type="password" id="re_password" class="form-control" placeholder="repetir password">
                    @error('re_password') <div class="alert alert-danger w-100 mt-2"> {{$message}} </div> @enderror
            </div>
            <div class="form-group form-check col-md-6">
                <div class="icheck-primary">
                    <input wire:model='admin' type="checkbox" id="admin" >
                    <label class="form-check-label" for="admin">Es Administrado?</label>
                </div>
            </div>
            <div class="form-group form-check col-md-6" >
                <div class="icheck-primary">
                    <input wire:model='activo' type="checkbox" id="activo" >
                    <label class="form-check-label" for="activo">Esta Activo?</label>
                </div>
            </div>

        </div>

        <hr>
        <button class="btn btn-primary float-right">{{$Id==0 ? 'Guardar' :  'Editar'}}</button>
        
    </form>
</x-modal>    