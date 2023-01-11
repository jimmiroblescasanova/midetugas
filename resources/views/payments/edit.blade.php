@extends('layouts.main')

@section('title', 'Nuevo pago')

@section('header')
    <div class="col-sm-6">
        <h1><i class="fas fa-hand-holding-usd mr-2"></i>Información de ingreso</h1>
    </div>
    <div class="col-sm-6">
        <div class="float-right">
            <button type="button" id="closePayment" class="btn btn-success btn-sm">
                <i class="fas fa-check-circle mr-2"></i>
                Terminar pago
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('payments.edit-payment', [ 'payment' => $payment ])
        </div>
    </div>
@stop
