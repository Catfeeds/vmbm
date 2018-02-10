<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wechat_id', 300)->nullable()->comment('微信ID');
            $table->string('wechat_name', 300)->nullable()->comment('微信名');
            $table->string('money', 100)->nullable()->comment('消费金额');
            $table->unsignedInteger('num')->nullable()->default(0)->comment('获得纸巾数');
            $table->unsignedInteger('buy_num')->nullable()->default(0)->comment('购买纸巾数');
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
        Schema::dropIfExists('fans');
    }
}
