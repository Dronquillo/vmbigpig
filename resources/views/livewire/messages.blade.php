<div>
    @if (session()->has('msg'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Mensaje Usuario! </strong> {{ session('msg') }}
            <button type="button" class="close" data-dismiss="alert"  aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
</div>
