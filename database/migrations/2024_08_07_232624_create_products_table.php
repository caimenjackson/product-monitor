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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->integer('on_hand')->default(0);
            $table->integer('cooked')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('wasted')->default(0);
            $table->integer('expiration_duration')->default(60); // duration in minutes
            $table->date('date')->default(DB::raw('CURRENT_DATE'));

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }

};
