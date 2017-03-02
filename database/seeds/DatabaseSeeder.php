<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'nama' => 'admin',
            'alamat' => '-',
            'telepon' => '-',
            'gaji' => 0,
            'username' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
    }
}
