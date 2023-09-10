<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefMotor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_merk_motor',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('status');
                $table->longText('description')->nullable();
                $table->commonFields();
            }
        );

        Schema::create(
            'ref_seri_motor',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('merk_id');
                $table->string('code')->unique();
                $table->text('model');
                $table->longText('description')->nullable();
                $table->commonFields();

                $table->foreign('merk_id')->references('id')->on('ref_merk_motor');    
            }
        );

        Schema::create(
            'ref_tahun_motor',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seri_id');
                $table->year('tahun');
                $table->text('harga')->nullable();
                $table->longText('description')->nullable();
                $table->commonFields();

                $table->foreign('seri_id')->references('id')->on('ref_seri_motor');    
            }
        );

        Schema::create(
            'ref_tipe_motor',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->longText('description')->nullable();
                $table->commonFields();
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
        Schema::dropIfExists('ref_tipe_motor');
        Schema::dropIfExists('ref_tahun_motor');
        Schema::dropIfExists('ref_seri_motor');
        Schema::dropIfExists('ref_merk_motor');
    }
}
