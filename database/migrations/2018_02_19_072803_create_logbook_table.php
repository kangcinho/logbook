<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('slug');
            $table->bigInteger('id_pasien')->unsigned()->nullable();
            $table->string('ppk',255)->nullable();
            $table->string('dokter_perujuk',255)->nullable();
            $table->integer('id_no_kamar')->unsigned();
            $table->integer('id_paket_kamar')->unsigned();
            $table->text('diagnosa')->nullable();
            $table->string('nama_dokter')->nullable();
            $table->text('keterangan_tindakan')->nullable();
            $table->string('no_sep',255)->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->char('status_logbook',1)->default(0);
            $table->string('nama_pasien',255)->nullable();
            $table->string('tlp_pasien',255)->nullable();
            $table->string('alamat_pasien',255)->nullable();
            $table->date('tgl_lahir_pasien')->nullable();
            $table->string('id_bpjs_pasien',255)->nullable();
            $table->string('kelas_bpjs_pasien',255)->nullable();
            $table->timestamps();

            $table->foreign('id_pasien')->references('id')->on('pasien');
            $table->foreign('id_no_kamar')->references('id')->on('no_kamar');
            $table->foreign('id_paket_kamar')->references('id')->on('paket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbook');
    }
}
