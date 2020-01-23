@extends('layouts.app')

@section('content')
    <div class="album">
        <div class="container py-2">
            <div class="row">
                <div class="col-md-8 left_side">
                    <h1>Create a Post</h1>

                    <form class="mt-4 mb-4" method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        @method('POST')
                        <div class="container mt-5">
                            <div class="row mb-2">
                                <div class="col-3">
                                    <h5 class="font-weight-light">Title</h5>
                                </div>
                                <div class="col-9">
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="title" value="{{ old('title') }}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <h5 class="font-weight-light">Caption</h5>
                                </div>
                                <div class="col-9">
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="description" value="{{ old('description') }}" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <h5 class="font-weight-light">Image URL</h5>
                                </div>
                                <div class="col-9">
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="img_url" value="{{ old('img_url') }}" required/>
                                    </div>
                                    <input type="submit" class="btn btn-secondary mt-3">
                                </div>
                            </div>
                        </div>
                    </form>
                    @include ('errors')
                </div>
                {{--                {{ dd(Request::cookie('theme')) }}--}}
                <div class="col-md-4 right-side">
                    @include('layouts.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection
