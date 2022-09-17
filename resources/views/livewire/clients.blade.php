<div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hand-holding-usd"></i> Clientes</h1>
                </div>
                @can('create_clients')
                    <div class="col-sm-6">
                        <a href="{{ route('clients.create') }}"
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
                                <div class="col-12 col-sm-5 form-group">
                                    <label for="search">Buscar:</label>
                                    <input type="text" wire:model="search" id="search" class="form-control"
                                        placeholder="Nombre, nombre corto, email o referencia">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="orderColumn">Ordenar por:</label>
                                    <select wire:model="orderColumn" id="orderColumn" class="form-control">
                                        <option value="id">ID</option>
                                        <option value="name">Nombre</option>
                                        <option value="shortName">Nombre Corto</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="orientation">Orientacion:</label>
                                    <select wire:model="orientation" id="orientation" class="form-control">
                                        <option value="asc">Ascendente</option>
                                        <option value="desc">Descendente</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 form-group">
                                    <label for="perPage">Mostrar:</label>
                                    <select wire:model="perPage" id="perPage" class="form-control">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="col-sm-1 form-group mt-auto">
                                    <button wire:click="clear" class="btn btm-sm btn-default btn-block">Limpiar</button>
                                </div>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>nombre</th>
                                        <th>nombre corto</th>
                                        <th>email</th>
                                        <th>referencia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td scope="row">{{ $cliente->id }}</td>
                                            <td>{{ $cliente->name }}</td>
                                            <td>{{ $cliente->shortName }}</td>
                                            <td>{{ $cliente->email }}</td>
                                            <td>{{ $cliente->reference }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('clients.show', $cliente) }}"
                                                    class="btn btn-xs btn-default">
                                                    <i class="fas fa-eye mr-2"></i>Ver / Editar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $clientes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
