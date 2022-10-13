@bind($measurer)
<div class="row">
    <div class="col-md-6">
        <x-form-input name="brand" label="Marca:" />
    </div>
    <div class="col-md-6">
        <x-form-input name="model" label="Modelo:" />
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <x-form-input name="serial_number" label="Número de serie:" />
    </div>
    <div class="col-md-6">
        <x-form-select name="correction_factor" label="Seleccionar condominio:" :options="$factors" class="select2bs4" />
    </div>
</div>
@endbind
