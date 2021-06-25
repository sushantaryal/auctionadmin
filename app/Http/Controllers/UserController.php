<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::orderBy('role')->latest();
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d h:i:s A');
                })
                ->editColumn('role', function ($user) {
                    return ucfirst($user->role);
                })
                ->addColumn('action', function ($user) {
                    return '<form action="' . route('users.destroy', $user->id) . '" method="post" delete-confirm="Are you sure you want delete this user?">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        <a class="btn btn-info btn-sm" href="' . route('users.edit', $user->id) . '"><i class="fas fa-pencil-alt"></i> Edit</a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class)
            ],
            'password' => ['required', 'string', new Password, 'confirmed']
        ]);

        $data = $request->only(['name', 'email', 'role']);
        $data['password'] = bcrypt($request->password);

        User::create($data);

        return back()->with('success', 'User has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ]
        ]);

        $user->fill($request->only(['name', 'email', 'role']));
        $user->save();

        return back()->with('success', 'User has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User has been deleted successfully.');
    }
}
