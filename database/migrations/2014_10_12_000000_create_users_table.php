<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('document',100);
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('cellphone');
            $table->string('area');
            $table->string('position',45);
            $table->string('password', 100);
            $table->string('profile',45);
            $table->string('enable',10);
            $table->string('slug');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
