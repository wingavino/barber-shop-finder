<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShopVerifiedAtToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
          if (!Schema::hasColumn('shops', 'shop_verified_at')) {
            Schema::table('shops', function (Blueprint $table) {
              $table->timestamp('shop_verified_at')->nullable()->before('approved');
            });
          }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('shop_verified_at');
        });
    }
}
