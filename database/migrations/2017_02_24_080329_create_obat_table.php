<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nama');
            $table->unsignedInteger('id_pamakologi');
            $table->string('dosis');
            $table->string('satuan_dosis');
            $table->string('bentuk_sediaan');
            $table->unsignedInteger('harga_jual');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');
            $table->foreign('id_pamakologi')->references('id')->on('pamakologi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat');
    }
}
