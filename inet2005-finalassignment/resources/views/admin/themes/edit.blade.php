@extends('layouts.app')

@section('content')
    <h1>Bootstrap Themes Administration - Edit</h1>

    <form class="mt-4 mb-4" method="POST" action="{{ route('themes.update',$theme->id) }}">
        @csrf
        @method('PUT')
        <div class="container mt-5">
            <div class="row mb-2">
                <div class="col-3">
                    <h5 class="font-weight-light">Name</h5>
                </div>
                <div class="col-9">
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="name" value={{ $theme->name }} />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-light">CDN_url</h5>
                </div>
                <div class="col-9">
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="cdn_url" value={{ $theme->cdn_url }} required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-light">Make Default Theme</h5>
                </div>
                <div class="col-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_default" value="1" {{ $theme->is_default == 1 ? "checked" : null }} />
                        </label>
                    </div>
                    <input type="submit" class="btn btn-secondary mt-3">
                </div>
            </div>
        </div>
    </form>
    @include ('errors')
@endsection
