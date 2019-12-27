<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Account;

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
        $user->account()->save(factory(Account::class)->make());

        $writer = new User;
        $writer->name = 'Nabidad Waraich';
        $writer->email = 'nabs@hotmail.co.uk';
        $writer->password = bcrypt('bw3179');
        $writer->save();
        $writer->roles()->attach(Role::where('name', 'writer')->first());
        $writer->account()->save(factory(Account::class)->make());
        

        $admin = new User;
        $admin->name = 'Bahawal Waraich';
        $admin->email = 'bahawal@hotmail.co.uk';
        $admin->password = bcrypt('bw3179');
        $admin->save();
        $admin->roles()->attach(Role::where('name', 'admin')->first());
        $admin->account()->save(factory(Account::class)->make());

        $roles = App\Role::all();  


        //Creates 10 normal users
        factory(App\User::class,10)->create()->each(function($user) {
            $user->roles()->save(Role::where('name','user')->first());
            $user->account()->save(factory(Account::class)->make());
        });

        //Creates 10 writer users
        factory(App\User::class,10)->create()->each(function($writer) {
            $writer->roles()->save(Role::where('name','user')->first());
            $writer->account()->save(factory(Account::class)->make());
        });

        //Creates 10 admin users
        factory(App\User::class,10)->create()->each(function($admin) {
            $admin->roles()->save(Role::where('name','admin')->first());
            $admin->account()->save(factory(Account::class)->make());
        });
        
    }
}


