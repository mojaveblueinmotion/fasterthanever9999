<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefAsuransiMobil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_asuransi_mobil',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('perusahaan_asuransi_id');
                $table->unsignedBigInteger('interval_pembayaran_id');
                $table->string('pembayaran_persentasi');
                $table->string('name');
                // $table->integer('kisaran_harga_awal')->unsigned();
                // $table->integer('kisaran_harga_akhir')->unsigned();
                // $table->integer('pembayaran_persentasi')->unsigned();
                // $table->integer('kerusakan_persentasi')->unsigned();
                $table->string('call_center');
                $table->commonFields();

                $table->foreign('perusahaan_asuransi_id')->on('ref_perusahaan_asuransi')->references('id');
                $table->foreign('interval_pembayaran_id')->on('ref_interval_pembayaran')->references('id');
            }
        );

        Schema::create('ref_asuransi_mobil_fitur', function (Blueprint $table) {
            $table->unsignedBigInteger('asuransi_id');
            $table->unsignedBigInteger('fitur_id');

            $table->foreign('asuransi_id')->references('id')->on('ref_asuransi_mobil')->onDelete('cascade');
            $table->foreign('fitur_id')->references('id')->on('ref_fitur_asuransi');

            $table->primary(['asuransi_id', 'fitur_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_asuransi_mobil_fitur');
        Schema::dropIfExists('ref_asuransi_mobil');
    }
}
