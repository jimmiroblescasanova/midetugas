<?php

if (!function_exists('setActive')) {
    function setActive($routeName)
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}

if (!function_exists('showMenu')) {
    function showMenu($routeName)
    {
        return request()->routeIs($routeName) ? 'menu-open' : '';
    }
}

if (!function_exists('setBadge')) {
    function setBadge($state)
    {
        if ($state) {
            return '<span class="badge badge-success">En uso</span>';
        } else {
            return '<span class="badge badge-danger">Inactivo</span>';
        }
    }
}

if (!function_exists('status')) {
    function status($state)
    {
        switch ($state) {
            case 1:
                return '<small><span class="badge badge-warning">Pendiente</span></small>';
            case 2:
                return '<small><span class="badge badge-primary">Autorizado</span></small>';
            case 3:
                return '<small><span class="badge badge-danger">Cancelado</span></small>';
            case 4:
                return '<small><span class="badge badge-success">Pagado</span></small>';
            default:
                return 'Something went wrong';
        }
    }
}

if (!function_exists('contabilidad')) {
    function contabilidad($number)
    {
        return "$ " . number_format($number, 2);
    }
}
