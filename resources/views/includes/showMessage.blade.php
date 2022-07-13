{{-- mensaje para una alerta que indique si se dio bien la respuesta --}}
@if (session('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
@endif