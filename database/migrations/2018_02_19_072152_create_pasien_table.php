<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->text('slug');
            $table->string('nama',255);
            $table->string('no_rm',255);
            $table->string('tlp',255)->nullable();
            $table->text("alamat")->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('id_bpjs',255)->nullable();
            $table->string('kelas_bpjs',255)->nullable();
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
        Schema::dropIfExists('pasien');
    }
}
