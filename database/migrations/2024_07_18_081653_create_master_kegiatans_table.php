<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kegiatan', function (Blueprint $table) {
            $table->id('kegiatan_id');
            $table->string('kode');
            $table->string('klp');
            $table->string('fung');
            $table->string('sub');
            $table->string('no');
            $table->Text('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_kegiatan');
    }
}
