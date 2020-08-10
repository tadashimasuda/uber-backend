<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('file_path');
            $table->string('area');
            $table->integer('way');
            $table->integer('time');
            $table->string('message');
            $table->integer('reward');
            $table->integer('user_id');
            $table->timestamps();
            
            $table->primary('id');// 重複不可
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
