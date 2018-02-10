<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTissuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tissues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fan_id')->comment('购买的微信用户ID');
            $table->unsignedInteger('device_id')->comment('设备ID');
            $table->unsignedInteger('ad_id')->nullable()->comment('领取时点击了哪个广告');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态：0领取；1购买');
            $table->unsignedInteger('num')->nullable()->default(0)->comment('份数');
            $table->string('money', 100)->nullable()->default(0)->comment('付款金额');
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
        Schema::dropIfExists('tissues');
    }
}
