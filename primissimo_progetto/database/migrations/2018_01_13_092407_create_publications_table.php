<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('idPublication');
            $table->string('titolo')->nullable();
            $table->timestamp('dataPubblicazione')->nullable();
            $table->string('pdf')->nullable();
            $table->string('immagine')->nullable();
            $table->string('multimedia')->nullable();
            $table->string('tipo')->nullable();
            $table->boolean('visibilita')->nullable();
            $table->string('tags')->nullable();
            $table->string('coautori')->nullable();
            $table->integer('idUser')->unsigned();
            $table->integer('idUser')->foreign('idPublication')->references('id')->on('users');
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
        Schema::dropIfExists('publications');
    }
}
