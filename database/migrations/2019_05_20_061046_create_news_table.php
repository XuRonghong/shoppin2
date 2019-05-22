<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'rank' )->default( 0 );
            $table->integer( 'authorId' )->comment('發布者')->default( 1 );;
            $table->integer( 'categoryId' )->comment('類別')->default( 1 );
            $table->string( 'title', 127 )->nullable();
            $table->string( 'summary', 255 )->nullable();
            $table->string( 'image', 255 )->nullable();
            $table->string( 'url', 255 )->comment('相關連結')->nullable();
            $table->longText( 'detail' )->nullable();
            $table->dateTime( 'startTime' )->nullable();;
            $table->dateTime( 'endTime' )->nullable();;
            $table->tinyInteger( 'open' )->default( 0 );
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
        Schema::dropIfExists('news');
    }
}
