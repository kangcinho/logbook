<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_kamar', function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug');
            $table->string('no_kamar',255);
            $table->text('deskripsi_no_kamar')->nullable();
            $table->integer('id_kamar')->unsigned();
            $table->timestamps();
            $table->foreign('id_kamar')->references('id')->on('kamar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('no_kamar');
    }
}
