<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('cognome');
            $table->date('dataNascita');
            $table->boolean('visibilitaDN')->default(1);
            $table->string('email')->unique();
            $table->boolean('visibilitaE')->default(1);
            $table->string('nazionalita');
            $table->boolean('visibilitaN')->default(1);
            $table->string('affiliazione');
            $table->string('dipartimento');
            $table->string('linea_ricerca');
            $table->string('telefono');
            $table->boolean('visibilitaT')->default(1);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
