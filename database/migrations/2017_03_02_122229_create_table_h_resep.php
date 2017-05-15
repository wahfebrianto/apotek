<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHResep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_resep', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->uuid('id_racikan');
            $table->string('nama_racikan');
            $table->string('bentuk_sediaan');
            $table->unsignedInteger('total');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('biaya_kemasan');
            $table->unsignedInteger('diskon');
            $table->unsignedInteger('grand_total');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['no_nota', 'id_racikan']);
            $table->foreign('no_nota')->references('no_nota')->on('h_jual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('h_resep');
    }
}
