<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('idComment');
            $table->integer('idGroup')->unsigned();
            $table->integer('idPublication')->unsigned();
            $table->integer('idUser')->unsigned(); 
            $table->integer('idGroup')->foreign('idGroup')->references('idGroup')->on('groups');
            $table->integer('idPublication')->foreign('idPublication')->references('id')->on('publications');
            $table->integer('idUser')->foreign('idUser')->references('id')->on('users');
            $table->string('descrizione');
            $table->timestamp('dataoraC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
