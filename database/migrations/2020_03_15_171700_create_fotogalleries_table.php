<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotogalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotogalleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_it')->nullable();
            $table->string('nome_en')->nullable();
            $table->string('nome_de')->nullable();
            $table->string('nome_fr')->nullable();
            $table->string('nome_es')->nullable();
            $table->string('desc_it')->nullable();
            $table->string('desc_en')->nullable();
            $table->string('desc_de')->nullable();
            $table->string('desc_fr')->nullable();
            $table->string('desc_es')->nullable();
            $table->string('desc_breve_it')->nullable();
            $table->string('desc_breve_en')->nullable();
            $table->string('desc_breve_de')->nullable();
            $table->string('desc_breve_fr')->nullable();
            $table->string('desc_breve_es')->nullable();
            $table->boolean('visibile')->default(1);
            $table->boolean('stato')->default(1);
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
        Schema::dropIfExists('fotogalleries');
    }
}
