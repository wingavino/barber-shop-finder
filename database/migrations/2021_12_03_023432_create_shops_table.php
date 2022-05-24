<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('users')->cascadeOnUpdate()->nullOnDelete();
            $table->string('owner_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address');
            $table->decimal('lat', $precision = 11, $scale = 8)->nullable();
            $table->decimal('lng', $precision = 11, $scale = 8)->nullable();
            $table->timestamp('shop_verified_at')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
