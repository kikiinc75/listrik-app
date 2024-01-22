<?php

namespace App\Http\Controllers;

use App\Http\Request\User\CreateRequest;
use App\Http\Request\User\EditRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Acl\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::join('role_user', 'user_id', '=', 'users.id')
                ->join('roles', 'role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'username', 'roles.name as role_name');
            return DataTables::eloquent($users)
                ->make();
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();

        return view('user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password'))
        ]);

        $user->attachRole([$request->role]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->with(['Roles']);
        $roles = Role::get();

        return view('user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, User $user)
    {
        $arrayRequest = [
            'name' => $request->get('name'),
            'username' => $request->get('username'),
        ];
        if ($request->has('password') && $request->get('password') != null) {
            $arrayRequest = array_push($arrayRequest, [
                'password' => Hash::make($request->get('password'))
            ]);
        }

        $user->update($arrayRequest);
        $user->revokeAllRoles();
        $user->attachRole([$request->role]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
