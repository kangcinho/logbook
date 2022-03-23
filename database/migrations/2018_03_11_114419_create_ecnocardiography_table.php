<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcnocardiographyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecnocardiography', function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug');
            $table->date('tgl_ditindak')->nullable();
            $table->time('waktu_ditindak')->nullable();
            $table->bigInteger('id_pasien')->unsigned()->nullable();
            $table->text('surat_rujukan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('petugas_poli',255)->nullable();
            $table->string('petugas_fo',255)->nullable();
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
        Schema::dropIfExists('ecnocardiography');
    }
}
