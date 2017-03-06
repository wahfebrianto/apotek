<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHBeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_beli', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->unsignedInteger('id_pbf');
            $table->unsignedInteger('id_pegawai');
            $table->date('tanggal_pesan');
            $table->unsignedInteger('total');
            $table->unsignedInteger('diskon');
            $table->unsignedInteger('grand_total');
            $table->boolean('status_lunas')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('keterangan');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('no_nota');
            $table->foreign('id_pbf')->references('id')->on('pbf');
            $table->foreign('id_pegawai')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('h_beli');
    }
}
