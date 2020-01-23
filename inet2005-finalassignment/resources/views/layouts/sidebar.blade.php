<div class="position-fixed">
    <form action="/posts/create">
        <button type="submit" class="btn btn-primary w-100 mb-5">Post New Photo</button>
    </form>

    <p class="h3">About PhotoFeed</p>
    <p class="h5">A light and flaky photo feed... fell free to post!</p>

    {{--                        @if (in_array(Auth::user()->id, DB::table('role_user')->select('role_user.user_id')->where('role_user.role_id', '=', '2')->distinct()->pluck('role_user.user_id')->toArray()))--}}
    <p class="h3 mt-5">Your Current Theme</p>

    <div class="form-group">
        <form method="POST" action="{{ route('feed.cookie') }}">
            @csrf
            @method('POST')
            <select class="form-control" name="theme" onchange='this.form.submit();'>
                @foreach(Session::get('themes') ? Session::get('themes') : $themes as $theme)
                    {{--                                            <option name="is_default" value="{{ $theme->id }}" {{ App\Theme::where('is_default', '=', '1')->first()->id == $theme->id ? 'selected' : ''}}>{{ $theme->name }}</option>--}}
                    <option name="is_default" value="{{ $theme->id }}" {{$theme->id == $selectedId ? 'selected':''}} >{{ $theme->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    {{--                        @endif--}}
</div>
