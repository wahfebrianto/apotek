<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDResep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_resep', function (Blueprint $table) {
            $table->string('no_nota',10);
            $table->uuid('id_racikan');
            $table->uuid('id_obat');
            $table->float('jumlah');
            $table->unsignedInteger('harga_jual');
            $table->unsignedInteger('subtotal_jual');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['no_nota', 'id_racikan', 'id_obat']);
            $table->foreign(['no_nota', 'id_racikan'])->references(['no_nota', 'id_racikan'])->on('h_resep');
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
        Schema::dropIfExists('d_resep');
    }
}
