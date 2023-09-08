<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPolisProperti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'trans_polis_properti',
            function (Blueprint $table) {
                $table->id();
                $table->string('no_asuransi')->unique();
                // $table->string('no_max');
                $table->date('tanggal');
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('asuransi_id');
                $table->text('name');
                $table->text('phone');
                $table->text('email');
                $table->string('status');
                $table->commonFields();

                $table->foreign('agent_id')->references('id')->on('sys_users');   
                $table->foreign('asuransi_id')->references('id')->on('ref_asuransi_properti');    
            }
        );

        Schema::create(
            'trans_polis_properti_cek',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('district_id');
                $table->text('village');
                $table->longText('alamat');
                $table->unsignedBigInteger('okupasi_id');
                
                $table->unsignedBigInteger('status_lantai');
                $table->unsignedBigInteger('status_bangunan');
                $table->unsignedBigInteger('status_banjir');
                $table->unsignedBigInteger('status_klaim');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_properti');   
                $table->foreign('okupasi_id')->references('id')->on('ref_okupasi');   
            }
        );

        Schema::create(
            'trans_polis_properti_nilai',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->bigInteger('nilai_bangunan')->unsigned();
                $table->bigInteger('nilai_isi')->unsigned();
                $table->bigInteger('nilai_mesin')->unsigned()->nullable();
                $table->bigInteger('nilai_stok')->unsigned();
                $table->bigInteger('nilai_pertanggungan')->unsigned();
                $table->date('tanggal_awal');
                $table->date('tanggal_akhir');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_properti');   
            }
        );

        Schema::create(
            'trans_polis_properti_payment',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->text('bank');
                $table->text('no_rekening');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_properti');   
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
        Schema::dropIfExists('trans_polis_properti_payment');
        Schema::dropIfExists('trans_polis_properti_nilai');
        Schema::dropIfExists('trans_polis_properti_cek');
        Schema::dropIfExists('trans_polis_properti');
    }
}
