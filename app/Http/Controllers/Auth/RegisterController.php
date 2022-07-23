<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string|unique:users,contact',
            'blood_group' => 'required|string',
            'address' => 'required|string',
            'institute' => 'nullable|string',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->blood_group = $data['blood_group'];
        $user->contact = $data['contact'];
        $user->address = $data['address'];
        $user->institute = $data['institute'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }
}
