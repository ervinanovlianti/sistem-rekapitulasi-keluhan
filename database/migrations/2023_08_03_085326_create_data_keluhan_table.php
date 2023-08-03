<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKeluhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_keluhan', function (Blueprint $table) {
            $table->string('id_keluhan');
            $table->dateTime('tgl_keluhan');
            $table->string('id_pengguna');
            $table->string('via_keluhan');
            $table->string('uraian_keluhan');
            $table->integer('kategori_id');
            $table->string('penanggungjawab')->nullable();
            $table->dateTime('waktu_penyelesaian')->nullable();
            $table->string('aksi')->nullable();
            $table->string('status_keluhan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_keluhan');
    }
}
