<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', $precision = 10, $scale = 2)->default(0.00);
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
        Schema::dropIfExists('shop_services');
    }
}
