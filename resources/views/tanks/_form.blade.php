@bind($tank)
    <div class="row">
        <div class="col-md-6 col-12">
            <x-form-select name="project_id" label="Seleccionar condominio:" :options="$projects" class="select2bs4" />
        </div>
        <div class="col-md-6 col-12">
            <x-form-input type="date" name="manufacturing_date" label="Selecciona una fecha:">
                @slot('prepend')
                    <i class="fas fa-calendar"></i>
                @endslot
            </x-form-input>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form-input name="brand" label="Marca:" />
        </div>
        <div class="col-12 col-md-6">
            <x-form-input name="model" label="Modelo:" />
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form-input name="serial_number" label="Número de serie:" />
        </div>
        <div class="col-12 col-md-6">
            <x-form-input type="number" name="capacity" label="Capacidad (L)" />
        </div>
    </div>
@endbind
