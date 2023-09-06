<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefTipeMobilBackup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create(
        //     'ref_tipe_mobil',
        //     function (Blueprint $table) {
        //         $table->id();
        //         $table->unsignedBigInteger('tahun_id');
        //         $table->string('name');
        //         $table->longText('description')->nullable();
        //         $table->commonFields();

        //         $table->foreign('tahun_id')->references('id')->on('ref_tahun_mobil');    
        //     }
        // );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('ref_tipe_mobil');
    }
}
