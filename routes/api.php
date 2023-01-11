<?php

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoriesController;

Route::post('inventories/fill-tank', [InventoriesController::class, 'fillTanks']);

Route::post('clients-from-project', function (Request $request){
    $clients = Client::where('project_id', $request->project)->orderBy('name', 'asc')->get(['id', 'name', 'shortName']);

    return $clients;
});