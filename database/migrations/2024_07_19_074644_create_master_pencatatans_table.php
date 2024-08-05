<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_pencatatan', function (Blueprint $table) {
            $table->id('pencatatan_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('rincian_id');
            // $table->string('keterangan');
            // $table->string('uraian_kegiatan');
            $table->integer('volume');
            $table->unsignedBigInteger('bobot_id');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            // $table->dateTime('waktu_batas');
            $table->integer('jam');
            $table->float('total');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('bobot_id')
                ->references('bobot_id')
                ->on('bobot')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('kegiatan_id')
                ->references('kegiatan_id')
                ->on('master_kegiatan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('rincian_id')
                ->references('rincian_id')
                ->on('master_rincian')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pencatatan');
    }
};
