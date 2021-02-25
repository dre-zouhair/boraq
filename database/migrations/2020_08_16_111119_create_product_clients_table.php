<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_clients', function (Blueprint $table) {
            $table->id();
            $table->double('P_S_price');
            $table->unsignedBigInteger('product_serial_id')->unique();
            $table->foreign('product_serial_id')
                ->references('id')
                ->on('product_serials')
                ->onDelete('cascade');
            $table->unsignedBigInteger('bill_id')->unique();
            $table->foreign('bill_id')
                ->references('id')
                ->on('bills')
                ->onDelete('cascade');

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
        Schema::dropIfExists('product_clients');
    }
}
