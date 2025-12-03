<x-card cardTitle='Detalles de la Compra'>
    <x-slot:cardTools>  
        <a href="{{ route('compras') }}" class="btn btn-primary">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </x-slot>
    
    <div class="row">
        {{-- Cabecera de la compra --}}
        <div class="col-md-12">
            <div class="card card-primary card-outline mb-4">
                <div class="card-body">
                    <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre ?? 'N/A' }}</p>
                    <p><strong>Número de Factura:</strong> {{ $compra->numero_factura }}</p>
                    <p><strong>Empresa:</strong> {{ $compra->empresa->nombre ?? 'N/A' }}</p>
                    <p><strong>Fecha:</strong> {{ $compra->fecha }}</p>
                    <p><strong>Estado:</strong> {{ $compra->estado }}</p>
                </div>
            </div>
        </div>

        
        {{-- Detalles --}}
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compraDetalle as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->producto->nombre ?? 'N/A' }}</td>
                            <td>{{ $d->cantidad }}</td>
                            <td>{{ number_format($d->precio_compra, 2) }}</td>
                            <td>{{ number_format($d->descuento, 2) }}</td>
                            <td>{{ number_format($d->subtotal, 2) }}</td>
                            <td>{{ number_format($d->iva, 2) }}</td>
                            <td>{{ number_format($d->subtotal - $d->descuento + $d->iva, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totales generales --}}
        <div class="col-md-12 mt-4">
            <div class="card bg-light">
                <div class="card-body">
                    <p><strong>Subtotal:</strong> {{ number_format($compra->subtotal, 2) }}</p>
                    <p><strong>Descuento:</strong> {{ number_format($compra->descuento, 2) }}</p>
                    <p><strong>IVA:</strong> {{ number_format($compra->iva, 2) }}</p>
                    <p class="h5 text-success"><strong>Total:</strong> {{ number_format($compra->total, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-card>

