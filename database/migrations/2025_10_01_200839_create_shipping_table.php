<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('shipping', function (Blueprint $table) {
        $table->id('shipping_id');
        $table->unsignedBigInteger('order_id');
        $table->string('address');
        $table->string('status')->default('preparing'); // preparing, shipped, delivered
        $table->timestamps();

        $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping');
    }
};