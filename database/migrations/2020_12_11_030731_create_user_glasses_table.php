<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGlassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_glasses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedFloat('left_eye_degree')->comment('眼睛度数')->default(5.0);
            $table->unsignedInteger('left_eye_astigmatism')->comment('眼睛散光度数')->default(0);
            $table->unsignedInteger('left_glasses_degree')->comment('眼镜片度数')->default(0);
            $table->unsignedInteger('left_glasses_astigmatism')->comment('眼镜散光度数')->default(0);

            $table->unsignedFloat('right_eye_degree')->comment('眼睛度数')->default(5.0);
            $table->unsignedInteger('right_eye_astigmatism')->comment('眼睛散光度数')->default(0);
            $table->unsignedInteger('right_glasses_degree')->comment('眼镜片度数')->default(0);
            $table->unsignedInteger('right_glasses_astigmatism')->comment('眼镜散光度数')->default(0);
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
        Schema::dropIfExists('user_glasses');
    }
}
