<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTissueRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tissue_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fan_id')->nullable()->comment('购买/领取的微信用户ID');
            $table->unsignedInteger('ad_id')->nullable()->comment('关注的广告ID');
            $table->tinyInteger('type')->nullable()->default(0)->comment('类型：0领取；1购买');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态：0创建；1使用');
            $table->timestamps();
        });
        DB::select("ALTER TABLE tissue_records COMMENT = '领取/购买预记录'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tissue_records');
    }
}
