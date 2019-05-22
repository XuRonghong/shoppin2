<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'rank' )->default( 0 );
            $table->integer( 'authorId' )->comment('發布者')->default( 1 );;
            $table->integer( 'categoryId' )->comment('類別')->default( 1 );
            $table->string( 'name', 127 )->nullable();
            $table->string( 'price', 127 )->nullable();
            $table->string( 'image', 127 )->nullable();
            $table->string( 'total', 127 )->nullable();
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
        Schema::dropIfExists('products');
    }
}
