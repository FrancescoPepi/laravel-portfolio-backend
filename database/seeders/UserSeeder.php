<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = new User();
        $users->name = 'Admin';
        $users->email = 'PortfolioFP@portfolio.com';
        $users->password = Hash::make('PortfolioFP.!');
        $users->save();
    }
}
