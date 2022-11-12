<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientePatologia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_patologia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->unsignedBigInteger('id_patologia')->nullable();
            $table->foreign('id_paciente')->references('id')->on('paciente');
            $table->foreign('id_patologia')->references('id')->on('patologias');
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
        Schema::dropIfExists('paciente_patologia');
    }
}
