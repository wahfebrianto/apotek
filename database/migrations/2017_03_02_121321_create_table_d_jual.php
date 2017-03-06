<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDJual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_jual', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->uuid('id_obat');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('harga_jual');
            $table->unsignedInteger('harga_beli');
            $table->unsignedInteger('subtotal_beli');
            $table->unsignedInteger('subtotal_jual');
            $table->unsignedInteger('diskon');
            $table->unsignedInteger('subtotal_jual_setelah_diskon');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['no_nota', 'id_obat', 'harga_beli']);
            $table->foreign('no_nota')->references('no_nota')->on('h_jual');
            $table->foreign('id_obat')->references('id')->on('obat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_jual');
    }
}
