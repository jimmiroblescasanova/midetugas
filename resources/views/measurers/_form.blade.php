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
        <x-form-select name="factor_id" label="Seleccionar factor de corrección:" class="select2bs4">
            @foreach ($factors as $id => $psig)
                <option value="{{ $id }}">{{ $psig }} PSIG</option>
            @endforeach
        </x-form-select>
    </div>
</div>
@endbind
