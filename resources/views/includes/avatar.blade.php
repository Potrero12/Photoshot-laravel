@if (Auth::user()->image)
    <div class="container-avatar">
        {{-- mostrar imagen usar el url() --}}
        <img src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" class="avatar" alt="avatar usuario" />
    </div>
@endif