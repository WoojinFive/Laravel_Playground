@extends('layouts.app')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('fail'))
        <div class="alert alert-danger">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <h1>Bootstrap Themes Administration</h1>
        <div class="row m-0 mt-5">
            <div>
                <form action="{{ url('/admin/themes/create') }}" method="post" class="custom-control-inline">
                    <button type="submit" class="btn btn-secondary my-2 my-sm-0" >Create New</button>
                    @method('GET')
                    @csrf
                </form>
            </div>
            <div class="mr-0 ml-auto mt-auto mb-auto">
                <form method="POST" action="/admin/themes/filter">
                    @csrf
                    <input type="radio" name="radio" value="saved" onchange='this.form.submit();' {{ $selectedRadio == 'saved' ? "checked" : "" }}><label class="ml-1">Saved</label>
                    <input type="radio" name="radio" value="deleted" class="ml-2" onchange='this.form.submit();' {{ $selectedRadio == 'deleted' ? "checked" : "" }}><label class="ml-1">Deleted</label>
                </form>
            </div>
        </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped table-sm">
            <thead>
            <tr class="d-flex">
                <th class="col-2">Name</th>
                <th class="col-7">CDN_url</th>
                <th class="col-1">Is Default</th>
                <th class="col-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($themes as $theme)
                <tr class="d-flex">
                    <td class="col-2">{{ $theme->name }}</td>
                    <td class="col-7">{{ $theme->cdn_url }}</td>
                    <td class="col-1">{{ $theme->is_default == 1 ? "Yes" : "No" }}</td>
                    <td class="col-2">
                        @if ($selectedRadio == 'saved')
                            <button type="submit" class="btn btn-sm btn-warning" style="background-color: darkorange; color: white; border-color: darkorange;" onclick=location.href="{{"/admin/themes/". $theme->id. "/edit"}}">Edit</button>
                            <button
                                type="button"
                                class="btn btn-sm btn-danger"
                                data-toggle="modal"
                                data-id="{{ $theme->id }}"
                                data-target="#DeleteModal"
                                onclick="deleteData({{$theme->id}})">
                                Delete
                            </button>
                        @elseif ($selectedRadio == 'deleted')
                            <form action="{{ url('/admin/themes/' . $theme->id . '/restore') }}" method="post" class="custom-control-inline">
                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')" >Restore</button>
                                @method('get')
                                @csrf
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @include('layouts.delModal')

    <script type="text/javascript">
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route("themes.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>

@endsection
