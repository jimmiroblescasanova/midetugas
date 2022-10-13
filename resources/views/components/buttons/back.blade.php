@props(['route' => null])

<a href="{{ ($route != null) ? route($route) : '/' }}" class="btn btn-sm btn-danger">
    <i class="fas fa-hand-point-left mr-2"></i>Atrás
</a>
