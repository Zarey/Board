<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            status:
                created - 0
                changed - 1
                approved - 2
                rejected - 3
        */
        Schema::create('board_advertisements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('author_id')->nullable(); // id автора (для права crud)
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('on_off')->default(1);
            $table->string('url')->nullable();
            $table->string('draft_header')->nullable();
            $table->string('header')->nullable();
            $table->text('draft_advcontent')->nullable();
            $table->text('advcontent')->nullable();
            $table->foreignId('draft_category_id')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->string('draft_image')->nullable();
            $table->string('image')->nullable();
            $table->string('draft_phone')->nullable();
            $table->string('phone')->nullable();
            $table->string('draft_city')->nullable();
            $table->string('city')->nullable();
            $table->integer('price')->nullable();
            $table->tinyInteger('currency')->default(1);
            $table->dateTime('up_adv', 0); // время поднятия объявления
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
        //
        Schema::dropIfExists('board_advertisements');
    }
}
