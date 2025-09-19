<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'role_uuid' => '00000001',
                'roles_desc' => 'Administrator with full access',
            ],
            [
                'name' => 'Manager',
                'role_uuid' => '00000011',
                'roles_desc' => 'Manager with moderate access',
            ],
             [
                'name' => 'Employee',
                'role_uuid' => '00000111',
                'roles_desc' => 'Employee with limited access',
            ],
            [
                'name' => 'Salesperson',
                'role_uuid' => '00001111',
                'roles_desc' => 'Salesperson with sales-focused access',
            ],
        ]);
    }
}
