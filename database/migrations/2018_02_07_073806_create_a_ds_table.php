<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateADsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wechat_id', 300)->nullable()->comment('微信/公众号ID');
            $table->string('wechat_name', 300)->nullable()->comment('微信/公众号名');
            $table->string('name', 300)->nullable()->comment('商家名称');
            $table->string('tel', 100)->nullable()->comment('商家电话');
            $table->string('money', 100)->nullable()->comment('投放充值金额');
            $table->unsignedInteger('limit')->default(0)->nullable()->comment('吸粉数量上限');
            $table->unsignedInteger('num')->default(0)->nullable()->comment('已吸粉数量');
            $table->unsignedInteger('day_limit')->default(0)->nullable()->comment('每日吸粉数量上限');
            $table->date('begin_date')->nullable()->comment('投放开始日期');
            $table->date('end_date')->nullable()->comment('投放截止日期');
            $table->tinyInteger('flag')->nullable()->default(0)->comment('轮换标志：0为默认；1为正在轮换');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态：0为下架；1为上架');
            $table->string('info', 200)->nullable()->comment('备注');
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
        Schema::dropIfExists('ads');
    }
}
