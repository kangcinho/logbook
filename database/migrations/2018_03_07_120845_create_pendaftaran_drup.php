<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendaftaranDrup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upadana', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('slug');
            $table->date('tgl_reservasi')->nullable();
            $table->time('pukul_reservasi')->nullable();
            $table->bigInteger('id_pasien')->unsigned()->nullable();
            $table->string('nomor_antrian',255)->nullable();
            $table->char('konfirmasi',1)->default(0);
            $table->string('nama_pasien',255)->nullable();
            $table->string('tlp_pasien',255)->nullable();
            $table->text('alamat_pasien')->nullable();
            $table->date('tgl_lahir_pasien')->nullable();
            $table->string('id_bpjs_pasien',255)->nullable();
            $table->string('kelas_bpjs_pasien',255)->nullable();
            $table->timestamps();
            $table->foreign('id_pasien')->references('id')->on('pasien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resv_dr_upadana');
    }
}
