<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDBeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_beli', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->uuid('id_obat');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('harga_beli');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('diskon');
            $table->unsignedInteger('subtotal_setelah_diskon');
            $table->date('tanggal_terima')->nullable();
            $table->unsignedInteger('id_pegawai_penerima')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['no_nota', 'id_obat']);
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
        Schema::dropIfExists('d_beli');
    }
}
