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
        Schema::create('product',function (Blueprint $table){
            $table->id();
            $table->bigInteger('company_id')->unsigned()->index();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->string('name');
            $table->decimal('price');
            $table->string('description')->nullable();
            $table->date('production_date');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
                //*************************image_path we will us mediable************************//
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product');

    }
};
