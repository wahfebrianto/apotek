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
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('no_nota');
            $table->foreign('id_pbf')->references('id')->on('pbf');
            $table->foreign('id_pegawai')->references('id')->on('users');
        });

          $autogen = "CREATE FUNCTION `autogenID_HBeli`()
          RETURNS varchar(10) CHARSET latin1
              NO SQL
            BEGIN
            	DECLARE URUT INT;
                DECLARE TGL VARCHAR(6);
                DECLARE NOTA VARCHAR(10);

                SET TGL = DATE_FORMAT(NOW(), '%d%m%y');
                SELECT IFNULL(COUNT(*),0)+1 INTO URUT
                FROM h_beli
                WHERE SUBSTR(no_nota,1,7) = CONCAT('N',TGL);

                SET NOTA = CONCAT('N',TGL,LPAD(URUT,3,'0'));
            	RETURN NOTA;
            END";

        DB::unprepared("DROP FUNCTION IF EXISTS autogenID_HBeli");
        DB::unprepared($autogen);
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
