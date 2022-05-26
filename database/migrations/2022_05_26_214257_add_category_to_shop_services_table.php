<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToShopServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('shop_services', 'category')) {
        Schema::table('shop_services', function (Blueprint $table) {
          $table->string('category')->nullable()->after('name');
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_services', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
}
