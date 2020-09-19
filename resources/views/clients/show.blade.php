@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="custom-tabs-four-home-tab"
                                   data-toggle="pill"
                                   href="#custom-tabs-four-home"
                                   role="tab"
                                   aria-controls="custom-tabs-four-home"
                                   aria-selected="true"
                                >Datos generales</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="custom-tabs-four-profile-tab"
                                   data-toggle="pill"
                                   href="#custom-tabs-four-profile"
                                   role="tab"
                                   aria-controls="custom-tabs-four-profile"
                                   aria-selected="false"
                                >Información de contactos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="custom-tabs-four-messages-tab"
                                   data-toggle="pill"
                                   href="#custom-tabs-four-messages"
                                   role="tab"
                                   aria-controls="custom-tabs-four-messages"
                                   aria-selected="false"
                                >Dirección</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-home-tab">
                                <form action="{{ route('clients.store') }}" role="form" method="POST">
                                    @csrf
                                    @include('partials.forms.client')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit">Actualizar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-profile-tab">
                                <form action="{{ route('clients.contacts.store') }}" role="form" method="POST">
                                @csrf
                                  @include('partials.forms.contacts')
                                </form>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-messages-tab">
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus
                                volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce
                                nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue
                                ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur
                                eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur,
                                ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex
                                vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus.
                                Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop
