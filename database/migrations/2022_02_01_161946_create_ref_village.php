<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefVillage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_village',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('district_id');
                $table->string('code', 14)->nullable();
                $table->string('name', 64);
                $table->commonFields();

                $table->foreign('district_id')
                    ->on('ref_district')
                    ->references('id');
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
        Schema::dropIfExists('ref_village');
    }
}
