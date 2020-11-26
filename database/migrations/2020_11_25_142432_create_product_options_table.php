<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        0: {option: 4, quantity: 1, sub_stock: 0, add_price: 0}

        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('option_value_id')->index();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('sub_stock')->default(0)->comment('减去库存数');
            $table->float('add_price')->default(0)->comment('这个类型下加价多少');

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
        Schema::dropIfExists('product_options');
    }
}
