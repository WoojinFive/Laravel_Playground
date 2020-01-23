<?php

namespace App\Http\Controllers;

use App\User;
//use Request;
use App\Role;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $selectedRadio = "admin";

        $existId = DB::table('role_user')->select('role_user.user_id')->distinct()->pluck('role_user.user_id')->toArray();
        $users = DB::table('users')
            ->select('users.*')
            ->whereIn('users.id', $existId)
            ->where('deleted_at', '=', null)
            ->get();

        return view('admin.users.index', compact('users', 'selectedRadio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $allRoles = DB::table('roles')
            ->select('title', 'id')
            ->get();

        $assignedRoles = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'allRoles', 'assignedRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id.',id']
        ]);

        //update modified values
        $user->update($request->all());

        //update new roles
        $assignedRoles = $request->checkedRoles;
//        array_push($assignedRoles, Auth::user()->id);
        $syncRoles = $user->roles()->sync($assignedRoles);
        // update last_modified_by to pivot table for new role
        $user->roles()->updateExistingPivot($user->id, ['last_modified_by' => Auth::user()->getAuthIdentifier()]);

        $isChanged = count($user->getChanges());

        if ($isChanged === 0 && count($syncRoles['attached']) == 0 && count($syncRoles['detached']) == 0) {
            return redirect()->route('users.index');
        }

        // update last_modified_by
        $user->last_modified_by = $request->user()->id;
        $user->save();

        return redirect()->route('users.index')
            ->with('success','User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        // update last_modified_by
        $user->deleted_by = Auth::user()->id;
        $user->save();

        return redirect()->route('users.index')
            ->with('success','User deleted successfully!');
    }

    public function search(Request $request)
    {
        $selectedRadio = "admin";
//        $searchKeyword = Request::post('searchKeyword');
        $searchKeyword = $request -> post('searchKeyword');

        if($searchKeyword === null)
        {
            $selectedRadio = "all";
        }

        $users = DB::table('users')
            ->select('users.*')
            ->where('name','like', '%'.$searchKeyword.'%')
            ->orWhere('email','like', '%'.$searchKeyword.'%')
            ->get();

        return view('admin.users.index', compact('users', 'selectedRadio'));

    }

    public function filter(Request $request)
    {

        $selectedRadio = $request->radio;

        if($selectedRadio == 'all')   {
            $users = DB::table('users')
                ->select('users.*')
                ->where('deleted_at', '=', null)
                ->get();

        } else if ($selectedRadio == 'admin')   {
            $existId = DB::table('role_user')->select('role_user.user_id')->distinct()->pluck('role_user.user_id')->toArray();
            $users = DB::table('users')
                ->select('users.*')
                ->whereIn('users.id', $existId)
                ->where('deleted_at', '=', null)
                ->get();
        } else if ($selectedRadio == 'deleted')   {
            $users = DB::table('users')
                ->select('users.*')
                ->where('deleted_at', '!=', null)
                ->get();
        }

        return view('admin.users.index', compact('users', 'selectedRadio'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id)->restore();

        $selectedRadio = "all";

        $users = DB::table('users')
            ->select('users.*')
            ->where('deleted_at', '=', null)
            ->get();

        return redirect()->route('users.index');
    }

    protected function validateProject()
    {
        return request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user->id.',id']
        ]);
    }
}
