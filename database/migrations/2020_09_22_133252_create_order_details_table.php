<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); //FIELD INI AKAN MERUJUK KE TABLE orders
            $table->unsignedBigInteger('product_id'); //FIELD INI AKAN MERUJUK KE TABLE products
            $table->integer('price'); //INI SAMA DENGAN CUSTOMER, INFORMASI HARGA SAAT BARANG INI DIPESAN JUGA DIBUAT SALINNANNYA
            $table->integer('qty');
            $table->integer('weight');
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
        Schema::dropIfExists('order_details');
    }
}
