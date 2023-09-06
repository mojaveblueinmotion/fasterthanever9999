<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefTahunMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_tahun_mobil',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seri_id');
                $table->year('tahun');
                $table->text('harga')->nullable();
                $table->longText('description')->nullable();
                $table->commonFields();

                $table->foreign('seri_id')->references('id')->on('ref_seri_mobil');    
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_tahun_mobil');
    }
}
