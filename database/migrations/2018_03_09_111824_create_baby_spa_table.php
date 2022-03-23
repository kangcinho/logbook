<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBabySpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('babyspa', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->text('slug');
        $table->date('tgl_reservasi')->nullable();
        $table->time('pukul_reservasi_awal')->nullable();
        $table->time('pukul_reservasi_akhir')->nullable();
        $table->bigInteger('id_pasien')->unsigned()->nullable();
        $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('babyspa');
    }
}
