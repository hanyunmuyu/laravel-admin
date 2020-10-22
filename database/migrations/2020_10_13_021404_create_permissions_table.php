<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('api_path')->nullable()->index()->comment('权限对应的接口路由地址');
            $table->string('rule')->nullable()->comment('权限对应的规则');
            $table->string('method')->nullable()->comment('权限对应的请求方法');
            $table->string('title')->nullable()->comment('权限的名称');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('权限的父级分类');
            $table->unsignedTinyInteger('is_menu')->default(0)->comment('是否是菜单');
            $table->string('path')->nullable()->comment('权限对应的前端路由，用于前端做权限限制');
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
        Schema::dropIfExists('permissions');
    }
}
