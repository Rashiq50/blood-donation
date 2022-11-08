<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Exceptions\Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{

    public function run()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'blood_group' => "a+",
            'contact' => '012345678',
            'available' => 'not available',
            'password' => Hash::make('123456'),
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $students = json_decode(file_get_contents(storage_path() . "/data.json"), true);

        try{
            foreach($students as $student)
            {
                $student['password'] = Hash::make('123456');
                User::create($student);
            }
        }
        catch(Exception $th){
            
        }
    }
}
