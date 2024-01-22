<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Yajra\Acl\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $role = Role::create([
            'name' => 'Administrator',
            'slug' => Str::slug('Administrator')
        ]);

        $user = User::create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'password' => Hash::make('administrator'),
        ]);

        $user->attachRole([$role->id]);


        $role = Role::create([
            'name' => 'Pelanggan',
            'slug' => Str::slug('Pelanggan')
        ]);

        $cost = Cost::create([
            'power' => '900',
            'cost_per_kwh' => '900'
        ]);
    }
}
