<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_asset',
            function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->unsignedBigInteger('asset_type_id');
                $table->string('serial_number');
                $table->string('merk');
                $table->date('regist_date');
                $table->unsignedInteger('incident_count')->default(0);
                $table->unsignedInteger('problem_count')->default(0);
                $table->unsignedInteger('change_count')->default(0);
                $table->commonFields();

                $table->foreign('asset_type_id')
                    ->on('ref_asset_type')
                    ->references('id');
            }
        );

        Schema::create(
            'ref_asset_detail',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('asset_id');
                $table->string('name');
                $table->mediumText('description')->nullable();
                $table->commonFields();

                $table->foreign('asset_id')
                    ->on('ref_asset')
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
        Schema::dropIfExists('ref_asset_detail');
        Schema::dropIfExists('ref_asset');
    }
}
