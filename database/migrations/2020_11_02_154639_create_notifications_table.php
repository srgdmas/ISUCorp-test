<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //La categoria se define con un entero definiendose los siguientes significados para cada valor
        //0--->relacionado a usuarios
        //1--->relacionado a clinicas
        //2--->relacionado a casos
        //3--->relacionado a datos de facturacion
        //4--->relacionado a chat-cases
        //5--->relacionado a images-cases
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->integer('category');
            $table->dateTime('read_at')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('notifications');
    }
}
