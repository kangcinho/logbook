<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenomoranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penomoran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nomor_rujukan');
            $table->text('nomor_spri');
            $table->text('nomor_surat_kontrol');
            $table->string('nrm');
            $table->string('nama');
            $table->text('alamat');
            $table->date('tgl_lahir');
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
        Schema::dropIfExists('penomoran');
    }
}
