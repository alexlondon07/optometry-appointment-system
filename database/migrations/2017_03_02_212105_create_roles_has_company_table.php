<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesHasCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_has_company', function (Blueprint $table) {
            $table->increments('id');
            
            //Roles
			$table->integer('roles_id')->unsigned();
			$table->foreign('roles_id')->references('id')->on('roles');

            //Company
			$table->integer('company_id')->unsigned();
			$table->foreign('company_id')->references('id')->on('company');
            
            $table->string('rol');
            $table->string('responsability');
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
        Schema::drop('roles_has_company');
    }
}
