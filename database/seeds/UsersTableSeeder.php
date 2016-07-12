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
      DB::table('courses')->truncate();

      factory(App\User::class)->create([
          'name' => 'Alexander andres londoño espejo',
          'email' => 'admin@admin.com',
          'password' => 'admin',
          'profile' => 'super_admin',
          'enable' => 'si',
          'remember_token' => str_random(10)
      ]);
      factory(App\User::class, 30)->create();
      factory(App\Course::class, 5)->create();
    }
}
