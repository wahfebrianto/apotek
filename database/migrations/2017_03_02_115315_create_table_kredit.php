<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kredit', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->date('tanggal_jatuh_tempo');
            $table->boolean('status_lunas');
            $table->string('keterangan');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('no_nota');
            $table->foreign('no_nota')->references('no_nota')->on('h_beli');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kredit');
    }
}
