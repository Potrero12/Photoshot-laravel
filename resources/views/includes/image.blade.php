<div class="card pub_image">
    <div class="card-header">
        @if ($image->user->image)                            
            <div class="container-avatar">
                {{-- mostrar imagen usar el url() --}}
                <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar" />
            </div>
        @endif

        <div class="data-user">
            <a href="{{ route('image.detail', ['id' => $image->id])}}">
                {{$image->user->name.' '.$image->user->surname}}
                <span class="nickname">
                    {{' | @'.$image->user->nick}}
                </span>
            </a>
        </div>
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
            <div class="comments">                                
                <a href="" class="btn btn-sm btn-warning btn-comments">
                    Comentarios ({{count($image->comments)}})
                </a>
            </div>
        @endif
    </div>
</div>