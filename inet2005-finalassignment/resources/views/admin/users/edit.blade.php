@extends('layouts.app')

@section('content')
    <h1>Users Administration - Edit</h1>

    <form class="mt-4 mb-4" method="POST" action="{{ route('users.update',$user->id) }}">
        @csrf
        @method('PUT')
        <div class="container mt-5">
            <div class="row mb-2">
                <div class="col-3">
                    <h5 class="font-weight-light">Name</h5>
                </div>
                <div class="col-9">
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="name" value={{ $user->name }} />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-light">Email</h5>
                </div>
                <div class="col-9">
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="email" value={{ $user->email }} required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <h5 class="font-weight-light">Roles</h5>
                </div>
                <div class="col-9">
                    @foreach($allRoles as $role)
                        <div class="checkbox">
                            <label>
                                @if($role->id == 3 && $user->id == 1)
                                    <input type="checkbox" name="checkedRoles[]" value="{{ $role->id }}" checked disabled />&nbsp&nbsp{{ $role->title }}
                                    <input type="hidden" name="checkedRoles[]" value="{{ $role->id }}" checked />
                                @else
                                    <input type="checkbox" name="checkedRoles[]" value="{{ $role->id }}" {{in_array($role->id, $assignedRoles) ? 'checked' : ''}} />&nbsp&nbsp{{ $role->title }}
                                @endif
                            </label>
                        </div>
                    @endforeach
                    <input type="submit" class="btn btn-secondary mt-3">
                </div>
            </div>
        </div>
    </form>
    @include ('errors')
@endsection
