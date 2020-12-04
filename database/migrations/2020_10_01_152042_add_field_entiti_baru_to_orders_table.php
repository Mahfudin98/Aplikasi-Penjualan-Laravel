<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldEntitiBaruToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('citie_id')->after('district_id');
            $table->integer('cost')->after('subtotal')->default(0);
            $table->string('shipping')->after('cost')->nullable();
            $table->char('status', 1)->default(0)->comment('0: new, 1: confirm, 2: process, 3: shipping, 4: done')->after('shipping');
            $table->string('tracking_number')->nullable()->after('status');
            $table->string('ref')->nullable()->after('tracking_number');
            $table->boolean('ref_status')->default(false)->after('ref');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('citie_id');
            $table->dropColumn('cost');
            $table->dropColumn('shipping');
            $table->dropColumn('status');
            $table->dropColumn('tracking_number');
            $table->dropColumn('ref');
            $table->dropColumn('ref_status');
        });
    }
}
