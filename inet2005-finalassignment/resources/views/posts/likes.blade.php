<div>
    {{--                                            {{ dd(Auth::user()->likes->where('post_id', '=', $post->id)->pluck('id')->count()) }}--}}
    @if(Auth::user() != null && Auth::user()->likes->where('post_id', '=', $post->id)->where('deleted_at', '=', null)->pluck('id')->count() === 1)
        <form action="{{ url('/posts', ['id' => $post->id]) }}" method="post" class="custom-control-inline p-0">
            <button type="submit" style="background: none; border: none;">
                <a class="p-0" href="#" style="color: #fff; border: none; text-align: center; outline: none; text-decoration: none;">
                    <small class="text-muted"><i class="fas fa-heart"></i> {{ App\Like::where('post_id', '=', $post->id)->pluck('id')->count() }}</small>
                </a>
            </button>
            @method('put')
            @csrf
        </form>
    @elseif(Auth::user() != null && Auth::user()->likes->where('post_id', '=', $post->id)->where('deleted_at', '=', null)->pluck('id')->count() === 0)
        <form action="{{ url('/posts', ['id' => $post->id]) }}" method="post" class="custom-control-inline p-0">
            <button type="submit" style="background: none; border: none;">
                <a class="p-0" href="#" style="color: #fff; border: none; text-align: center; outline: none; text-decoration: none;">
                    <small class="text-muted"><i class="far fa-heart"></i> {{ App\Like::where('post_id', '=', $post->id)->pluck('id')->count() }}</small>
                </a>
            </button>
            @method('put')
            @csrf
        </form>
    @else
        <button type="" style="background: none; border: none;">
            <a class="p-0" href="{{ route('login') }}" style="color: #fff; border: none; text-align: center; outline: none; text-decoration: none;">
                <small class="text-muted"><i class="far fa-heart"></i> {{ App\Like::where('post_id', '=', $post->id)->pluck('id')->count() }}</small>
            </a>
        </button>
    @endif
</div>
