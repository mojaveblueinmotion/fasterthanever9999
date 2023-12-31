<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sys_users',
            function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('jenis_kelamin')->nullable();
                $table->date('tgl_lahir')->nullable();
                $table->string('phone')->nullable();
                $table->string('password');
                $table->string('alamat')->nullable();
                $table->string('username')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('status')->default('active');
                $table->string('nik')->nullable();
                $table->string('image')->nullable();
                $table->rememberToken();
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
        Schema::dropIfExists('sys_users');
    }
}
