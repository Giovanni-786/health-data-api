<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePaciente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_sanguineo')->nullable();
            $table->string('altura')->nullable();
            $table->integer('peso')->nullable();
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
            $table->unsignedBigInteger('id_pessoa')->nullable();
            $table->unsignedBigInteger('id_patologias')->nullable();
            $table->unsignedBigInteger('id_alergias')->nullable();
            $table->unsignedBigInteger('id_medicamentos_controlados')->nullable();
            $table->timestamps();


            $table->foreign('id_pessoa')->references('id')->on('pessoa');
            $table->foreign('id_patologias')->references('id')->on('patologias');
            $table->foreign('id_alergias')->references('id')->on('alergias');
            $table->foreign('id_medicamentos_controlados')->references('id')->on('medicamentos_controlados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_paciente');
    }
}
