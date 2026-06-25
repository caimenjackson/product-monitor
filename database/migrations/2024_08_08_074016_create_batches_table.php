<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->dateTime('cooked_at');
            $table->dateTime('expires_at');
            $table->integer('fresh_sold')->default(0); // Pieces sold before expiration
            $table->integer('waste')->default(0);      // Pieces wasted
            $table->integer('expired_sold')->default(0); // Pieces sold after expiration
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('batches');
    }
}
