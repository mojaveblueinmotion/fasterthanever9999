<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_workshop',
            function (Blueprint $table) {
                $table->id();
                $table->text('name');
                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->longText('link_maps')->nullable();
                $table->longText('alamat')->nullable();
                $table->longText('description')->nullable();
                $table->commonFields();

                $table->foreign('province_id')->on('ref_province')->references('id');
                $table->foreign('city_id')->on('ref_city')->references('id');
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
        Schema::dropIfExists('ref_workshop');
    }
}
