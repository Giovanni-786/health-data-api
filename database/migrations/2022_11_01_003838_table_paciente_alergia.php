<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePacienteAlergia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_alergia', function (Blueprint $table) {
            $table->id();
            $table->string('nome_alergia')->nullable();
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->unsignedBigInteger('id_alergia')->nullable();
            $table->foreign('id_paciente')->references('id')->on('paciente');            
            $table->foreign('id_alergia')->references('id')->on('alergias');
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
        //
    }
}
