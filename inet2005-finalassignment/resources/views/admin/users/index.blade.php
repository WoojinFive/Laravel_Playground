@extends('layouts.app')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p class="mb-0">{{ $message }}</p>
        </div>
    @endif

    <h1>Users Administration</h1>
        <div class="row m-0">
            <div>
                <form class="form-inline mt-4 mb-4" method="POST" action="/admin/users/search">
                    @csrf
                    <input class="form-control mr-sm-2" type="text" name="searchKeyword" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
            <div class="mr-0 ml-auto mt-auto mb-auto">
                <form method="POST" action="/admin/users/filter">
                    @csrf
                    <input type="radio" name="radio" value="admin" onchange='this.form.submit();' {{ $selectedRadio == 'admin' ? "checked" : "" }}><label class="ml-1">Admin</label>
                    <input type="radio" name="radio" value="all" class="ml-2" onchange='this.form.submit();' {{ $selectedRadio == 'all' ? "checked" : "" }}><label class="ml-1">All User</label>
                    <input type="radio" name="radio" value="deleted" class="ml-2" onchange='this.form.submit();' {{ $selectedRadio == 'deleted' ? "checked" : "" }}><label class="ml-1">Deleted User</label>
                </form>
            </div>
        </div>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr class="d-flex">
                <th class="col-3">Name</th>
                <th class="col-7">Email</th>
                <th class="col-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="d-flex">
                    <td class="col-3">{{ $user->name }}</td>
                    <td class="col-7">{{ $user->email }}</td>
                    <td class="col-2">
                        @if ($selectedRadio == 'deleted')
                            <form action="{{ url('/admin/users/' . $user->id . '/restore') }}" method="post" class="custom-control-inline">
                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure?')" >Restore</button>
                                @method('post')
                                @csrf
                            </form>
                        @else
                        <button type="submit" class="btn btn-sm btn-warning" style="background-color: darkorange; color: white; border-color: darkorange;" onclick=location.href="{{"/admin/users/". $user->id. "/edit"}}">Edit</button>
                        <button
                            type="button"
                            class="btn btn-sm btn-danger"
                            data-toggle="modal"
                            data-id="{{ $user->id }}"
                            data-target="#DeleteModal"
                            onclick="deleteData({{$user->id}})">
                            Delete
                        </button>
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
            var url = '{{ route("users.destroy", ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>
@endsection
