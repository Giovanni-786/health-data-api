<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false); //acesso a tudo.
            $table->enum('cargo', ['medico', 'assistente', 'admin'])->nullable();
            $table->uuid('id_unidade')->nullable();
            $table->uuid('id_medico')->nullable();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name' => 'SuperAdmin',
                'email' => 'admin@gmail.com.br',
                'password' => bcrypt('1234'),
                'is_admin' => true,
                'cargo' => 'admin'
            )
        );
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
