<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-usd mr-2"></i>Medidores</h1>
                </div>
                @can('create_measurers')
                    <div class="col-sm-6">
                        <a href="{{ route('measurers.create') }}"
                            class="btn btn-primary btn-sm float-sm-right btn-block-xs-only">
                            <i class="fas fa-pencil-alt mr-2"></i>Crear nuevo</a>
                    </div>
                @endcan
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-4 form-group">
                                    <label for="search">Buscar:</label>
                                    <input type="text" wire:model.debounce.350ms="search" id="search"
                                        class="form-control" placeholder="Marca, modelo, num. de serie">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="orderColumn">Ordenar por:</label>
                                    <select wire:model="orderColumn" id="orderColumn" class="form-control">
                                        <option value="brand">Marca</option>
                                        <option value="model">Modelo</option>
                                        <option value="serial_number">Num. de serie</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="orientation">Orientacion:</label>
                                    <select wire:model="orientation" id="orientation" class="form-control">
                                        <option value="asc">Ascendente</option>
                                        <option value="desc">Descendente</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 form-group">
                                    <label for="perPage">Mostrar:</label>
                                    <select wire:model="perPage" id="perPage" class="form-control">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="status">Estado:</label>
                                    <select wire:model="status" id="status" class="form-control">
                                        <option value="1">En uso</option>
                                        <option value="0">Inactivos</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 form-group mt-auto">
                                    <button wire:click="clear" class="btn btm-sm btn-default btn-block">Limpiar</button>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Num. de serie</th>
                                        <th>Medida actual</th>
                                        <th>Factor</th>
                                        <th>Estado</th>
                                        <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medidores as $medidor)
                                        <tr>
                                            <td>{{ $medidor->brand }}</td>
                                            <td>{{ $medidor->model }}</td>
                                            <td>{{ $medidor->serial_number }}</td>
                                            <td>{{ $medidor->actual_measure }} m<sup>3</sup></td>
                                            <td>{{ $medidor->correction_factor }}</td>
                                            <td>{!! setBadge($medidor->active) !!}</td>
                                            <td>
                                                <a href="{{ route('measurers.edit', $medidor) }}"
                                                    class="btn btn-default btn-xs">
                                                    <i class="fas fa-edit mr-2"></i>Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $medidores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
