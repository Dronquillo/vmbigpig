<x-modal modalId="modalDetalles" modalTitle="Detalles del Control" modalSize="modal-lg">
    <div class="card">
        <div class="card-body">
            @if($controlSeleccionado && $controlSeleccionado->tipo === 'alimentacion')
                <h5>Productos utilizados</h5>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalles as $d)
                            <tr>
                            <td>{{ is_array($d) ? ($d['producto']['nombre'] ?? '') : ($d->producto->nombre ?? '') }}</td>
                            <td>{{ is_array($d) ? $d['cantidad'] : $d->cantidad }}</td>
                            <td>${{ number_format(is_array($d) ? $d['precio'] : $d->precio,2) }}</td>
                            <td>${{ number_format(is_array($d) ? $d['subtotal'] : $d->subtotal,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if($controlSeleccionado && $controlSeleccionado->tipo === 'chequeo')
                <h5>Chequeo Médico</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Veterinario:</strong> ${{ number_format($controlSeleccionado->veterinario_costo,2) }}</li>
                    <li class="list-group-item"><strong>Tipo:</strong> {{ ucfirst($controlSeleccionado->tipo_inseminacion) }}</li>
                    <li class="list-group-item"><strong>Fecha de monta/inseminación:</strong> {{ $controlSeleccionado->fecha }}</li>
                    <li class="list-group-item"><strong>Cerdo macho:</strong> {{ $controlSeleccionado->macho?->codigo ?? 'No registrado' }}</li>
                    <li class="list-group-item"><strong>Fecha próxima de chequeo:</strong> {{ $controlSeleccionado->fecha_preñez }}</li>
                </ul>
            @endif

        </div>
    </div>
</x-modal>
