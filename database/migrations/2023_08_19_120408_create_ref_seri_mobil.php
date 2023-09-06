<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefSeriMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_seri_mobil',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('merk_id');
                $table->string('code')->unique();
                $table->text('model');
                $table->longText('description')->nullable();
                $table->commonFields();

                $table->foreign('merk_id')->references('id')->on('ref_merk_mobil');    
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
        Schema::dropIfExists('ref_seri_mobil');
    }
}
