<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{

    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if(!auth()->user()->is_admin){
        //     abort(401);
        // }
        $users = User::all();
         return Inertia::render('Users/Index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if(!auth()->user()->is_admin){
        //     abort(401);
        // }
         return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // if(!auth()->user()->is_admin){
        //     abort(401);
        // }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ]);
        
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'is_admin' => $request['is_admin'],
            'is_jv' => $request['is_jv'],
            'is_siv' => $request['is_siv'],
        ]);

        return to_route('users.index');
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
    public function edit(string $id)
    {
        $user = User::find($id);
        return Inertia::render('Users/Edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $user->update($request->only(['email','name','is_admin','is_siv','is_jv']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
