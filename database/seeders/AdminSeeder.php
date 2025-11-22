<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin123@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
            ]
        );

        // attach admin role pivot if using roles table
        $role = \App\Models\Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
