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

        $autogen = "CREATE FUNCTION `autogenID_HJual`()
        RETURNS varchar(10) CHARSET latin1
            NO SQL
          BEGIN
            DECLARE URUT INT;
              DECLARE TGL VARCHAR(6);
              DECLARE NOTA VARCHAR(10);

              SET TGL = DATE_FORMAT(NOW(), '%m%y');
              SELECT IFNULL(COUNT(*),0)+1 INTO URUT
              FROM h_jual
              WHERE SUBSTR(no_nota,1,5) = CONCAT('J',TGL);

              SET NOTA = CONCAT('J',TGL,LPAD(URUT,5,'0'));
            RETURN NOTA;
          END";

          DB::unprepared("DROP FUNCTION IF EXISTS autogenID_HJual");
          DB::unprepared($autogen);
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
