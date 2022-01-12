<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('request_type');
            $table->string('change_to_user_type')->nullable();
            $table->string('report_reason')->nullable();
            $table->unsignedBigInteger('review_id')->nullable();
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            // $table->unsignedBigInteger('change_user_type_request_id')->nullable();
            // $table->foreign('change_user_type_request_id')->references('id')->on('change_user_type_requests')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->unsignedBigInteger('new_shop_request_id')->nullable();
            // $table->foreign('new_shop_request_id')->references('id')->on('new_shop_requests')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('pending_requests');
    }
}
