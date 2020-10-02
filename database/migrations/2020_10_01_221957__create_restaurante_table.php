<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestauranteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurante', function (Blueprint $table) {
            $table->id();
            $table->text('proprietario');
            $table->text('razao_social');
            $table->char('cnpj', 14);
            $table->string('telefone', 12);
            $table->char('cep', 8);
            $table->string('estado', 3);
            $table->text('cidade');
            $table->text('rua');
            $table->string('numero', 6);
            $table->text('complemento')->nullable();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurante');
    }
}
