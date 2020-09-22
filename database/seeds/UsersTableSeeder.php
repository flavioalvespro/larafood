<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenant = Tenant::first();

        $tenant->users()->create([
            'name' => 'Flávio Alves',
            'email' => 'flavioalvespro@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
