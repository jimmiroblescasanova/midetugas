<?php

function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function showMenu($routeName)
{
    return request()->routeIs($routeName) ? 'menu-open' : '';
}

function setBadge($state)
{
    if ($state)
    {
        return '<span class="badge badge-success">En uso</span>';
    } else {
        return '<span class="badge badge-danger">Inactivo</span>';
    }
}

function status($state)
{
    switch ($state)
    {
        case 1:
            return '<span class="badge badge-warning">Pendiente</span>';
        case 2:
            return '<span class="badge badge-primary">Autorizado</span>';
        case 3:
            return '<span class="badge badge-danger">Cancelado</span>';
        case 4:
            return '<span class="badge badge-success">Pagado</span>';
        default:
            return 'Something wne wrong';
    }
}
