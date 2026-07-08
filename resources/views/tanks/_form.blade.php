<div class="row">
    <div class="col-md-6 col-12">
        <x-form-select name="project_id" :bind="$tank ?? null" label="Seleccionar condominio:" :options="$projects" class="select2bs4" />
    </div>
    <div class="col-md-6 col-12">
        <x-form-input type="date" name="manufacturing_date" :bind="$tank ?? null" label="Selecciona una fecha:" />
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <x-form-input name="brand" :bind="$tank ?? null" label="Marca:" />
    </div>
    <div class="col-12 col-md-6">
        <x-form-input name="model" :bind="$tank ?? null" label="Modelo:" />
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <x-form-input name="serial_number" :bind="$tank ?? null" label="Número de serie:" />
    </div>
    <div class="col-12 col-md-6">
        <x-form-input type="number" name="capacity" :bind="$tank ?? null" label="Capacidad (L)" />
    </div>
</div>
