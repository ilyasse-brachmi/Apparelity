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
        Schema::create('material',function (Blueprint $table){
            $table->id();
            $table->bigInteger('product_id')->unsigned()->index();
            $table->string('name');
            $table->string('supplier');
            $table->string('address');
            $table->bigInteger('material_parent')->unsigned()->nullable(); 
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
            $table->foreign('material_parent')->references('id')->on('material')->onDelete('set null'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('material');

    }
};
