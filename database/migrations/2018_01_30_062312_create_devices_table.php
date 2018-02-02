<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->nullable()->default(0)->comment('所属客户');
            $table->string('name', 200)->nullable()->default('无')->comment('名称');
            $table->string('type', 200)->nullable()->default('无')->comment('型号');
            $table->string('location', 200)->nullable()->default('无')->comment('地点');
            $table->string('IMEI', 200)->nullable()->default('无')->comment('编码，IMEI地址');
            $table->string('code', 400)->nullable()->default('无')->comment('二维码');
            $table->tinyInteger('auth_status')->nullable()->default(0)->comment('审核状态：0，未审核；1，审核通过；2，审核不过');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态：0，离线；1，在线；2，缺纸；3，故障');
            $table->integer('tissue_num')->nullable()->default(0)->comment('纸巾数');
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
        Schema::dropIfExists('devices');
    }
}
