<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        return view('public.landing');
        
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
        if($request->last_donated){
            $start_date = new \Carbon\Carbon($request->last_donated);
            if (now()->diffInDays($start_date) <= 90) {
                $user->available = "not available";
                $user->save();
            }
        }
        return view('private.profile', compact('user'));
    }
}
