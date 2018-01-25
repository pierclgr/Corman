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
            $table->string('titolo');
            $table->timestamp('dataPubblicazione');
            $table->string('pdf');
            $table->string('immagine');
            $table->string('multimedia');
            $table->string('tipo');
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
