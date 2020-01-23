@extends('layouts.app')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <div class="album">
        <div class="container py-2">
            <div class="row">
                <div class="col-lg-8 left_side">
                    <div class="row position-sticky">
                        @foreach (Session::get('posts') ? Session::get('posts') : $posts as $post)
                        <div class="col-lg-6">
                            <div class="card mb-4 box-shadow">
                                <img
                                    class="card-img-top"
                                    data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail"
                                    alt="Thumbnail [100%x225]"
                                    style="{display: block; object-fit: scale-down; width: 100%; height: 255px;}"
                                    src="{{ $post->img_url }}"
                                    data-holder-rendered="true"
                                    onclick=location.href="{{"/posts/". $post->id}}" />
                                <div class="card-body">
                                    <div class="row justify-content-around" onclick=location.href="{{"/posts/". $post->id}}">
                                        <div class="col-lg-12">
                                            <p class="card-text">{{ $post->title }}</p>
                                            @if (strlen($post->description) > 70)
                                                <div style="{height: 24px; line-height: 24px; overflow: hidden;}">
                                                    <p class="card-text">{{ substr($post->description, 0, strrpos($post->description, ' ', (70-4)-strlen($post->description))) . ' ...' }}</p>
                                                </div>
                                            @else
                                                <div style="{height: 48px; line-height: 48px; overflow: hidden;}">
                                                    <p class="card-text">{{ $post->description }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        @include('posts.likes')
                                        <div>
                                            <small class="text-muted">Posted {{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }} by {{ $post->name }}</small>
                                        </div>
                                    </div>
                                    <div>
                                    @if (Auth::user() != null && Auth::user()->roles->where('id', '=', 1)->pluck('id')->first() === 1)
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger mt-3"
                                            data-toggle="modal"
                                            data-id="{{ $post->id }}"
                                            data-target="#DeleteModal"
                                            onclick="deleteData({{$post->id}})">
                                            Delete Post
                                        </button>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 right-side">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.delModal')

    <script>
        // https://stackoverflow.com/questions/51666591/dynamic-data-load-by-ajax-in-laravel
        // https://makitweb.com/fetch-records-from-mysql-with-jquery-ajax-laravel/
        var timestamp = parseInt(new Date()/1000);

        function doPoll() {
            $.ajax({
                method: 'GET',
                url: `/ajax?timestamp=${timestamp}`,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response['data'] !== null) {
                        window.location.reload();
                    }
                }
            });
            setTimeout(doPoll, 1000);
        }

        setTimeout(doPoll, 1000);
    </script>

    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("posts.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>
@endsection
