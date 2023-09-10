<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefAsuransiPerjalanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_asuransi_perjalanan',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('perusahaan_asuransi_id');
                $table->unsignedBigInteger('interval_pembayaran_id');
                $table->string('pembayaran_persentasi');
                $table->string('name');
                $table->string('call_center');
                $table->commonFields();

                $table->foreign('perusahaan_asuransi_id')->on('ref_perusahaan_asuransi')->references('id');
                $table->foreign('interval_pembayaran_id')->on('ref_interval_pembayaran')->references('id');
            }
        );

        Schema::create('ref_asuransi_perjalanan_fitur', function (Blueprint $table) {
            $table->unsignedBigInteger('asuransi_id');
            $table->unsignedBigInteger('fitur_id');

            $table->foreign('asuransi_id')->references('id')->on('ref_asuransi_perjalanan')->onDelete('cascade');
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
        Schema::dropIfExists('ref_asuransi_perjalanan_fitur');
        Schema::dropIfExists('ref_asuransi_perjalanan');
    }
}
