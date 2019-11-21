<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        
        
        $user = new User;
        $user->name = 'Elliot Norris';
        $user->email = 'elliotnorris@hotmail.co.uk';
        $user->password = bcrypt('elliot3179');
        $user->save();
        $user->roles()->attach(Role::where('name', 'user')->first());

        $user = new User;
        $user->name = 'Nabidad Waraich';
        $user->email = 'nabs@hotmail.co.uk';
        $user->password = bcrypt('bw3179');
        $user->save();
        $user->roles()->attach(Role::where('name', 'writer')->first());
        

        $admin = new User;
        $admin->name = 'Bahawal Waraich';
        $admin->email = 'bahawal@hotmail.co.uk';
        $admin->password = bcrypt('bw3179');
        $admin->save();
        $admin->roles()->attach(Role::where('name', 'admin')->first());

        $roles = App\Role::all();


        //Creates 10 normal users
        factory(App\User::class,10)->create()->each(function($user) {
            $user->roles()->save(Role::where('name','user')->first());
        });

        //Creates 10 admin users
        factory(App\User::class,10)->create()->each(function($user) {
            $user->roles()->save(Role::where('name','admin')->first());
        });
        
    }
}


