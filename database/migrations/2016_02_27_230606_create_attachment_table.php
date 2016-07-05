<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('attachment', function(Blueprint $table)
      {
              $table->increments('id');
              $table->unsignedInteger('user_id');
              $table->unsignedInteger('machine_id');
              $table->unsignedInteger('product_id');
              $table->string('name');
              $table->string('mime');
              $table->string('encode');
              $table->integer('size');
              $table->string('upload_path')->nullable();
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
      Schema::drop('attachment');
    }
}
