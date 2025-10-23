<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\History;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        History::truncate();   // remove histories referencing users
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // SUPERADMIN
        User::create([
            'name' => 'Hafidz Super Admin',
            'username' => 'brohafidz',
            'email' => 'hafidz.super@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'parent_user_username' => null,
        ]);

        // ADMIN
        User::create([
            'name' => 'Admin One',
            'username' => 'admin1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'parent_user_username' => null,
        ]);

        User::create([
            'name' => 'Admin Two',
            'username' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin9876'),
            'role' => 'admin',
            'parent_user_username' => null,
        ]);

        // ANAK (Children)
        User::create([
            'name' => 'Amir',
            'username' => 'anak_amir',
            'email' => 'amir.child@domain.com',
            'password' => Hash::make('hash_child1'),
            'role' => 'anak',
            'parent_user_username' => null,
        ]);

        User::create([
            'name' => 'Bela',
            'username' => 'anak_bela',
            'email' => 'bela.child@domain.com',
            'password' => Hash::make('hash_child2'),
            'role' => 'anak',
            'parent_user_username' => null,
        ]);

        User::create([
            'name' => 'Rio Junior',
            'username' => 'rio_junior',
            'email' => 'rio.junior@domain.com',
            'password' => Hash::make('hash_child3'),
            'role' => 'anak',
            'parent_user_username' => null,
        ]);

        User::create([
            'name' => 'Sasa Kecil',
            'username' => 'sasa_kecil',
            'email' => 'sasa.kecil@domain.com',
            'password' => Hash::make('hash_child4'),
            'role' => 'anak',
            'parent_user_username' => null,
        ]);

        User::create([
            'name' => 'Udin Siwa',
            'username' => 'udin_siwa',
            'email' => 'udin.siwa@domain.com',
            'password' => Hash::make('hash_child5'),
            'role' => 'anak',
            'parent_user_username' => null,
        ]);

        // ORANGTUA (Parents) - with parent_user_username references
        User::create([
            'name' => 'Bapak Andi',
            'username' => 'bapak_andi',
            'email' => 'andi.ayah@domain.com',
            'password' => Hash::make('hash_parent1'),
            'role' => 'orangtua',
            'parent_user_username' => 'admin1', // References admin1 username
        ]);

        User::create([
            'name' => 'Ibu Santi',
            'username' => 'ibu_santi',
            'email' => 'santi.mama@domain.com',
            'password' => Hash::make('hash_parent2'),
            'role' => 'orangtua',
            'parent_user_username' => 'admin2', // References admin2 username
        ]);
    }
}