@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Buscar Usuarios</h1>
            <form method="GET" action="{{ route('user.index') }}" id="buscador">
                
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control"/>
                    </div>
                    <br />
                    <div class="form-group col btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success"/>
                    </div>
                </div>

            </form>

            @foreach ($users as $user)
            <div class="profile-user">
                    @if ($user->image)                       
                        <div class="container-avatar">
                            {{-- mostrar imagen usar el url() --}}
                            <img src="{{ route('user.avatar',['filename'=>$user->image]) }}" class="avatar" />
                        </div>
                    @endif
                <div class="user-info">
                    <h2 class="nickname">{{'@'.$user->nick}}</h2>
                    <h3>{{$user->name.' '.$user->surname}}</h3>
                    <p class="nickname date">{{'Se unió: '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                    <a href="{{ route('profile', ["id" => $user->id]) }}" class="btn btn-success">Ver Perfil</a>
                </div>

                <div class="clearfix"></div>
                <hr />
                
            </div>
            @endforeach

            {{-- paginacion --}}
            <div class="clearfix"></div>
            <div class="pagination">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
