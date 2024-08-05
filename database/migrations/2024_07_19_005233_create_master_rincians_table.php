<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRinciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('master_rincian', function (Blueprint $table) {
            $table->id('rincian_id');
            $table->string('kode');
            $table->string('keg');
            $table->string('rk');
            $table->string('iki');
            $table->Text('uraian_kegiatan');
            $table->Text('uraian_rencana_kinerja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_rincian');
    }
};