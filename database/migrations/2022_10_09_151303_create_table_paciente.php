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
            $table->string('nome');
            $table->string('nacionalidade')->nullable();
            $table->string('sexo')->nullable();
            $table->timestamp('data_nascimento')->nullable();
            $table->string('tipo_sanguineo')->nullable();
            $table->string('altura')->nullable();
            $table->integer('peso')->nullable();
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
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
        Schema::dropIfExists('table_paciente');
    }
}
