@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @include('includes/showMessage')
                <div class="card pub_image pub_image_detail">
                    <div class="card-header">
                        @if ($image->user->image)                            
                            <div class="container-avatar">
                                {{-- mostrar imagen usar el url() --}}
                                <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar" alt="avatar usuario" />
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
                                {{-- comprobar si le dio like a la imagen --}}
                                @php $user_like = false; @endphp
                                @foreach ($image->likes as $like)
                                    @if ($like->user->id == Auth::user()->id)
                                        @php $user_like = true; @endphp
                                    @endif
                                @endforeach

                                @if ($user_like)
                                    <img src="{{asset('img/colorrojo.png')}}" class="btn-dislike" data-id = "{{$image->id}}" alt="dislike" />
                                @else 
                                    <img src="{{asset('img/colorgris.png')}}" class="btn-like" data-id = "{{$image->id}}" alt="like" />
                                @endif
                                <span class="number_likes">({{count($image->likes)}})</span>
                            </div>
                            
                            <div class="clearfix"></div>

                            <div class="comments">                                
                                <h2>Comentarios ({{count($image->comments)}})</h2>
                                <hr />

                                <form action="{{ route('comment.save') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="image_id" value="{{$image->id}}"/>
                                    <p>
                                        <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''}}" name="content" cols="30" rows="5"></textarea>

                                        @error('content')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </p>

                                    <button type="submit"  class="btn btn-success">
                                        Enviar
                                    </button>

                                </form>
                                <hr />
                                @foreach ($image->comments as $comment)
                                    <div class="comment">
                                            <span class="nickname">{{'@'.$comment->user->nick}}</span>
                                            <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                                            <p>{{$comment->content}}</p>

                                            @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">
                                                    Eliminar
                                                </a>
                                            @endif
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection
