<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('first_surname');
            $table->string('second_surname');
            $table->string('document_type',45);
            $table->string('document_of_identity',100);
            $table->string('date_of_birth');
            $table->string('age', 10);
            $table->string('gender',45);
            $table->string('address');
            $table->string('contact_name');
            $table->string('one_contact_phone');
            $table->string('two_contact_phone');
            $table->string('email')->unique();
            $table->string('password', 100);
            $table->string('enable',10);
            $table->string('slug');
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
        Schema::drop('students');
    }
}
