<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHJual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_jual', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->date('tgl');
            $table->unsignedInteger('id_pegawai');
            $table->unsignedInteger('total');
            $table->unsignedInteger('diskon');
            $table->unsignedInteger('grand_total');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('no_nota');
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
        Schema::dropIfExists('h_jual');
    }
}
