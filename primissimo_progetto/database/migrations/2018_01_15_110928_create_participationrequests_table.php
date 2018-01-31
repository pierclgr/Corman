<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participationrequests', function (Blueprint $table) {
            /*
            $table->integer('idGroup')->unsigned();
            $table->integer('idUser')->unsigned();
            */
            $table->integer('idGroup')->foreign('idGroup')->references('idGroup')->on('groups');
            $table->integer('idUser')->foreign('idUser')->references('id')->on('users');
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
        Schema::dropIfExists('participationrequests');
    }
}
