<div>
    <x-card cardTitle="Dashboard de Alimentación">
        <div class="form-group">
            <label>Seleccione Lote</label>
            <select wire:model="lot_id" class="form-control">
                <option value="">-- Seleccione --</option>
                @foreach($lots as $lot)
                    <option value="{{ $lot->id }}">{{ $lot->code }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <button wire:click="cargarInformacion" class="btn btn-primary" @disabled(!$lot_id)>
                Mostrar Información
            </button>
        </div>

        @if($mostrarDashboard)
            <ul class="nav nav-tabs mt-4">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#animales">Animales</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#planes">Planes</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#eventos">Eventos</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pesos">Pesos</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#chequeos">Chequeos</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#alertas">Alertas</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#partos">Partos</a></li>
            </ul>

            <div class="tab-content mt-3">
                <div id="animales" class="tab-pane fade show active">
                    @include('livewire.feeding.partials.animals')
                </div>

                <div id="planes" class="tab-pane fade">
                    @include('livewire.feeding.partials.plans')
                </div>

                <div id="eventos" class="tab-pane fade">
                    @include('livewire.feeding.partials.events')
                </div>

                <div id="pesos" class="tab-pane fade">
                    @include('livewire.feeding.partials.weights')
                </div>

                <div id="chequeos" class="tab-pane fade">
                    @include('livewire.feeding.partials.checks')
                </div>

                <div id="alertas" class="tab-pane fade">
                    @include('livewire.feeding.partials.alerts')
                </div>

                <div id="partos" class="tab-pane fade">
                    @include('livewire.feeding.partials.births')
                </div>
            </div>
        @endif
    </x-card>
</div>

