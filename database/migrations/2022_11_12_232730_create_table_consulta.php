<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableConsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->unsignedBigInteger('id_medico')->nullable();
            $table->unsignedBigInteger('id_unidade')->nullable();
            $table->date('data_consulta')->nullable();
            $table->string('tipo_consulta')->nullable();
            $table->mediumText('observacoes')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('paciente');
            $table->foreign('id_medico')->references('id')->on('medico');
            $table->foreign('id_unidade')->references('id')->on('unidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta');
    }
}
