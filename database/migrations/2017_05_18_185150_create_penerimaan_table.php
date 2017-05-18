<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenerimaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('penerimaan', function (Blueprint $table) {
          $table->uuid('id');
          $table->string('no_nota',10);
          $table->uuid('id_obat');
          $table->unsignedInteger('jumlah');
          $table->date('tanggal_expired');
          $table->date('tanggal_terima');
          $table->string('keterangan')->nullable();
          $table->timestamps();
          $table->softDeletes();
          $table->primary('id');
          $table->foreign('no_nota')->references('no_nota')->on('h_beli');
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
        Schema::dropIfExists('penerimaan');
    }
}
