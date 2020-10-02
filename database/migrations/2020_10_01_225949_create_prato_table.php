<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prato', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->decimal('preco', 5,2);
            $table->integer('cardapio_id');
            $table->foreign('cardapio_id')->references('id')->on('cardapio');
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
        Schema::dropIfExists('prato');
    }
}
