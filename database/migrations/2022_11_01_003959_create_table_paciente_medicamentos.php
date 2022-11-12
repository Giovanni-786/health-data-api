<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePacienteMedicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->unsignedBigInteger('id_medicamentos_controlados')->nullable();
            $table->foreign('id_paciente')->references('id')->on('paciente');
            $table->foreign('id_medicamentos_controlados')->references('id')->on('medicamentos_controlados');
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
        Schema::dropIfExists('table_paciente_medicamentos');
    }
}
