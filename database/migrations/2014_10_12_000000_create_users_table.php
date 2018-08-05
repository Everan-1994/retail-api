<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('avatar');
            $table->string('truename')->comment('真是姓名');
            $table->tinyInteger('sex')->default(1)->comment('1：男 2：女');
            $table->tinyInteger('identify')->default(3)->comment('1：超管 2：供应商 3：会员');
            $table->integer('pid')->default(0)->comment('供应商id');
            $table->integer('points')->default(0)->comment('积分');
            $table->tinyInteger('status')->default(1)->comment('1：正常 0：冻结');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
