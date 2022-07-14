@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes/showMessage')
                <div class="card pub_image">
                    <div class="card-header">
                        @if (Auth::user()->image)                            
                            <div class="container-avatar">
                                {{-- mostrar imagen usar el url() --}}
                                <img src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" class="avatar" alt="avatar usuario" />
                            </div>
                        @endif

                        <div class="data-user">
                        </div>
                        {{$image->user->name.' '.$image->user->surname}}
                        <span class="nickname">
                            {{' | @'.$image->user->nick}}
                        </span>
                    </div>
                    <div class="card-body">
                        @if ($image->image_path)
                            <div class="image-container">
                                <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="Imagen" />
                            </div>
                            <div class="description">
                                <span class="nickname">{{'@'.$image->user->nick}}</span>
                                <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($image->created_at)}}</span>
                                <p>{{$image->description}}</p>
                            </div>
                            <div class="likes">
                                <img src="{{asset('img/colorgris.png')}}" alt="like" />
                            </div>
                            <div class="comments">                                
                                <a href="" class="btn btn-sm btn-warning btn-comments">
                                    Comentarios ({{count($image->comments)}})
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection
