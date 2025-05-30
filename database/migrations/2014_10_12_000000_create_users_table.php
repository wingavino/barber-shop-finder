<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('provider_id')->nullable();
            $table->string('mobile')->nullable();
            $table->string('type')->default('user');
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('id_verified_at')->nullable();
            $table->boolean('banned')->default(false);
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
          'name' => 'Superadmin',
          'email' => 'saber.shop.finder@gmail.com',
          'type' => 'admin',
          'email_verified_at' => Carbon::now(),
          'id_verified_at' => Carbon::now(),
          'password' => Hash::make('admin')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
