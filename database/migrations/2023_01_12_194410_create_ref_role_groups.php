<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefRoleGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_role_groups',
            function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->unsignedBigInteger('role_id');
                $table->commonFields();

                $table->foreign('role_id')
                    ->on('sys_roles')
                    ->references('id');
            }
        );
        Schema::create(
            'ref_role_group__asset_types',
            function (Blueprint $table) {
                $table->unsignedBigInteger('role_group_id');
                $table->unsignedBigInteger('asset_type_id');

                $table->foreign('role_group_id')
                    ->on('ref_role_groups')
                    ->references('id');
                $table->foreign('asset_type_id')
                    ->on('ref_asset_type')
                    ->references('id');
            }
        );
        Schema::create(
            'ref_role_group__members',
            function (Blueprint $table) {
                $table->unsignedBigInteger('role_group_id');
                $table->unsignedBigInteger('user_id');

                $table->foreign('role_group_id')
                    ->on('ref_role_groups')
                    ->references('id');
                $table->foreign('user_id')
                    ->on('sys_users')
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
        Schema::dropIfExists('ref_role_group__members');
        Schema::dropIfExists('ref_role_group__asset_types');
        Schema::dropIfExists('ref_role_groups');
    }
}
