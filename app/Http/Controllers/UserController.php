<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
    
class UserController extends Controller
{

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'blood_group' => 'required|string',
        ]);
    
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->blood_group = $request->blood_group;
        $user->contact = $request->contact;
        $user->address = $request->address;
        $user->institute = $request->institute;
        $user->password = Hash::make('123456');
        $user->save();

        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function createDonor()
    {
        return view('donors.create');
    }

    public function addDonor(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:donors,email',
            'contact' => 'required|string|unique:donors,contact',
            'blood_group' => 'required|string',
            'address' => 'required|string',
            'institute' => 'nullable|string',
        ]);
    
        $donor = new Donor();
        $donor->name = $request->name;
        $donor->email = $request->email;
        $donor->blood_group = $request->blood_group;
        $donor->contact = $request->contact;
        $donor->address = $request->address;
        $donor->institute = $request->institute;
        $donor->save();
            
        return redirect()->route('addDonor')
                        ->with('success','Donor created successfully');
    }


    
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}