<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransPolisPerjalanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'trans_polis_perjalanan',
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

                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('district_id');
                $table->text('village');
                $table->longText('alamat');

                $table->date('tanggal_lahir');
                $table->text('nik');
                $table->text('pekerjaan');
                $table->date('tanggal_awal');
                $table->date('tanggal_akhir');

                $table->unsignedBigInteger('from_province_id');
                $table->unsignedBigInteger('from_city_id');

                $table->unsignedBigInteger('destination_province_id');
                $table->unsignedBigInteger('destination_city_id');
                
                $table->text('ahli_waris');
                $table->text('hubungan_ahli_waris');

                $table->longText('catatan');

                $table->string('status');
                $table->commonFields();

                $table->foreign('agent_id')->references('id')->on('sys_users');   
                $table->foreign('asuransi_id')->references('id')->on('ref_asuransi_perjalanan');    
            }
        );

        Schema::create(
            'trans_polis_perjalanan_payment',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('polis_id');
                $table->text('bank');
                $table->text('no_rekening');
                $table->commonFields();

                $table->foreign('polis_id')->references('id')->on('trans_polis_perjalanan');   
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
        Schema::dropIfExists('trans_polis_perjalanan_payment');
        Schema::dropIfExists('trans_polis_perjalanan');
    }
}
