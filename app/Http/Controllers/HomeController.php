<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('private.profile', compact('user'));
    }

    public function saveProfile(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update($request->all());
        return view('private.profile', compact('user'));
    }
}
