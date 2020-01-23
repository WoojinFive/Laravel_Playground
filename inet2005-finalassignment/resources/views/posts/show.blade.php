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
                <div class="col-md-8 left_side pr-5 pb-5">
                    <div class="row position-sticky">
                        <div class="col-md-12 p-0">
                            <form action="{{ route('posts.index') }}">
                                <button type="submit" class="btn btn-primary w-20 mb-5">Back</button>
                            </form>
                        </div>
                        <h2>{{ $post->title }}</h2>
                        <img
                            class="card-img-top"
                            data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail"
                            alt="Thumbnail [100%x225]"
                            style="{display: block; width:100%;}"
                            src="{{ $post->img_url }}"
                            data-holder-rendered="true" />
                        <div class="d-flex justify-content-start align-items-center mt-3 w-100">
                            <p class="text-muted">{{ $post->name }} on {{ Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}</p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center w-100">
                            @include('posts.likes')
                            <p class="text-muted m-0" style="font-size: 0.8rem;">by
                                @if (strlen($comma_seperated_names) > 70)
                                    <p class="text-muted m-0 ml-2" style="font-size: 0.8rem;">
                                        {{ substr($comma_seperated_names, 0, strrpos($comma_seperated_names, ' ', (70-4)-strlen($comma_seperated_names))) . ' ...' }}
                                    </p>
                                @else
                                    <p class="text-muted m-0 ml-2" style="font-size: 0.8rem;">{{ $comma_seperated_names }}</p>
                                @endif
                            </p>
                        </div>
                        <div class="d-flex justify-content-start align-items-center mt-3 mb-3 w-100">
                            <p class="text-muted h4">{{ $post->description }}</p>
                        </div>

                        <p class="text-muted h4">Comments</p>
                        @foreach($comments as $comment)
                            <div class="container align-items-center mt-2 w-100">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row justify-content-end">
                                            <div class="col-md-11">
                                                <span class="text-muted m-0 font-weight-bold">{{ $comment->name }}</span>
                                                <span class="text-muted m-0 ml-1" style="font-size: 0.8rem;">{{ Carbon\Carbon::parse($comment->updated_at)->diffForHumans() }}</span>
                                            </div>
                                            @if (Auth::check())
                                                @if($comment->user_id === Auth::user()->id)
                                                <div class="col-md-1">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-6 p-0" id="edit_button{{ $comment->id }}">
                                                            <button type="button" class="btn btn-sm btn-outline-primary border-0" onclick="toggleEdit({{ $comment->id }})"><i class="fas fa-pencil-alt"></i></button>
                                                        </div>
                                                        <div class="col-md-6 p-0 d-none" id="edit_confirm_button{{ $comment->id }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary border-0" onclick="submitEdit({{ $comment->id }})"><i class="fas fa-check" ></i></button>
                                                        </div>
                                                        <div class="col-md-6 p-0" id="delete_button{{ $comment->id }}">
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-outline-danger border-0"
                                                                data-toggle="modal"
                                                                data-id="{{ $comment->id }}"
                                                                data-target="#DeleteModal"
                                                                onclick="deleteData({{$comment->id}})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
    {{--                                                        <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="form-inline">--}}
    {{--                                                            @method('delete')--}}
    {{--                                                            @csrf--}}
    {{--                                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i></button>--}}
    {{--                                                        </form>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-md-1"></div>
                                                @endif
                                            @endif
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="comment_content{{ $comment->id }}">
                                        <p class="text-muted m-0"> {{ $comment->content }}</p>
                                    </div>

                                    <div class="col-md-12 d-none" id="comment_edit_input{{ $comment->id }}">
                                        <form method="POST" action="{{ route('comments.update', $comment->id) }}" class="form-inline" id="comment_edit_submit{{ $comment->id }}">
                                            @method('put')
                                            @csrf
                                            <input type="text" name="modified_content" class="w-75" value="{{ $comment->content }}" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

{{--                        @if (Auth::check())--}}
                        <div class="d-flex justify-content-start align-items-center w-100">
                            <form method="POST" action="{{ route('comments.store') }}" class="w-100" id="comment_form">
                                @method('post')
                                @csrf
                                <div class="d-flex justify-content-start align-items-center mt-3 w-100">
                                    <textarea class="w-100" name="newComment" placeholder="Your comment here." {{ Auth::check() ? '' : "onclick=moveLogin()"}}></textarea>
                                    <input type="hidden" name="postId" value="{{ $post->id }}" checked/>
                                </div>

                                <div class="d-flex justify-content-start align-items-center mt-3 w-100">
                                    <button type="submit" class="btn btn-primary w-20 mb-5">Add Comment</button>
                                </div>
                            </form>
                        </div>
{{--                        @endif--}}
                    </div>
                </div>
                <div class="col-md-4 right-side">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.delModal')

    <script>
        function toggleEdit (id) {
            $("#edit_button"+id).addClass("d-none");
            $("#edit_confirm_button"+id).removeClass("d-none");
            $("#comment_content"+id).addClass("d-none");
            $("#comment_edit_input"+id).removeClass("d-none");
        }

        function submitEdit (id) {
            $('#comment_edit_submit'+id).submit();
        }
    </script>

    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("comments.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>

    <script>
        function moveLogin()
        {
            $("#comment_form").submit();
        }
    </script>

@endsection
