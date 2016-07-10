<?php

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
      DB::table('attachment')->truncate();
      DB::table('users')->truncate();

      factory(App\User::class)->create([
          'name' => 'Alexander andres londoño espejo',
          'email' => 'admin@admin.com',
          'password' => bcrypt('admin'),
          'profile' => 'super_admin',
          'enable' => 'si',
          'remember_token' => str_random(10)
      ]);
      factory(App\User::class, 12)->create();
    }
}
