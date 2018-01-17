<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupspublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupspublications', function (Blueprint $table) {
            $table->integer('idUser')->foreign('idUser')->references('id')->on('users');
            $table->integer('idGroup')->foreign('idGroup')->references('idGroup')->on('groups');
            $table->integer('idPublication')->foreign('idPublication')->references('id')->on('publications');
            $table->string('descrizione');
            $table->timestamp('dataoraGP');
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
        Schema::dropIfExists('groupspublications');
    }
}
