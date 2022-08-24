<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Hardik Savani',
            'email' => 'snuora2019@gmail.com',
            'password' => bcrypt('123123123'),
            'image' => 'profile.png',
            'image_id' => "sadsda",
            'gender' => 1,
            'status' => "1",
            'location' => "wqeqwe",
            'mobile' => '0595913186',
            'role' => "admin",
            "email_verified_at" => now(),
        ]);
        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
