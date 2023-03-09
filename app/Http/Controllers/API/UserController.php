<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => "required|min:3|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|max:255"
        ]);
        $user = User::create([
            "name" => $validation["name"],
            "email" => $validation["email"],
            "password" => bcrypt($validation["password"])
        ]);
        return 1;
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        
    }
    /**
     * login function hh.
     */
    public function login(Request $request){
        $validation = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8|max:255"
        ]);
        if(auth()->attempt($validation)){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        User::where("id", $user->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::where("id", $user->id)->delete();
        return 1;
    }
}
