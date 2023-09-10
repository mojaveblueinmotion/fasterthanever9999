<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPolisMotor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'trans_polis_motor',
            function (Blueprint $table) {
                $table->id();
                $table->string('no_asuransi')->unique();
                $table->string('no_max');
                $table->date('tanggal');
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('asuransi_id');
                $table->text('name');
                $table->text('phone');
                $table->text('email');
                $table->string('status');
                $table->commonFields();

                $table->foreign('agent_id')->references('id')->on('sys_users');   
                $table->foreign('asuransi_id')->references('id')->on('ref_asuransi_motor');    
            }
        );

        Schema::create(
            'trans_polis_motor_cek',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->unsignedBigInteger('merk_id');
                $table->unsignedBigInteger('tahun_id');
                $table->unsignedBigInteger('tipe_id');
                $table->unsignedBigInteger('seri_id');
                $table->unsignedBigInteger('tipe_kendaraan_id');
                $table->text('kode_plat');
                $table->unsignedBigInteger('tipe_pemakaian_id');
                $table->unsignedBigInteger('luas_pertanggungan_id');
                $table->unsignedBigInteger('kondisi_kendaraan_id');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_motor');   
                $table->foreign('merk_id')->references('id')->on('ref_merk_motor');   
                $table->foreign('tahun_id')->references('id')->on('ref_tahun_motor');   
                $table->foreign('tipe_id')->references('id')->on('ref_tipe_motor');   
                $table->foreign('seri_id')->references('id')->on('ref_seri_motor');   
                $table->foreign('tipe_kendaraan_id')->references('id')->on('ref_tipe_kendaraan');
                
                $table->foreign('tipe_pemakaian_id')->references('id')->on('ref_tipe_pemakaian');   
                $table->foreign('luas_pertanggungan_id')->references('id')->on('ref_luas_pertanggungan');   
                $table->foreign('kondisi_kendaraan_id')->references('id')->on('ref_kondisi_kendaraan');   
            }
        );

        Schema::create(
            'trans_polis_motor_nilai',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->longText('rincian_modifikasi');
                $table->bigInteger('nilai_modifikasi')->unsigned();
                $table->text('tipe');
                $table->bigInteger('nilai_motor')->unsigned();
                $table->bigInteger('nilai_pertanggungan')->unsigned();
                $table->year('tahun_awal')->nullable();
                $table->year('tahun_akhir')->nullable();
                $table->text('pemakaian');
                $table->date('tanggal_awal');
                $table->date('tanggal_akhir');
                $table->text('no_plat');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_motor');   
            }
        );

        Schema::create(
            'trans_polis_motor_client',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->text('nama');
                $table->text('phone');
                $table->text('email');
                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('district_id');
                $table->text('village');
                $table->longText('alamat');
                $table->text('warna');
                $table->longText('keterangan');
                $table->text('no_chasis');
                $table->text('no_mesin');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_motor');   
                $table->foreign('district_id')->references('id')->on('ref_district');
            }
        );

        Schema::create(
            'trans_polis_motor_payment',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->text('bank');
                $table->text('no_rekening');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_motor');   
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
        Schema::dropIfExists('trans_polis_motor_payment');
        Schema::dropIfExists('trans_polis_motor_client');
        Schema::dropIfExists('trans_polis_motor_nilai');
        Schema::dropIfExists('trans_polis_motor_cek');
        Schema::dropIfExists('trans_polis_motor');
    }
}
