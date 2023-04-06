<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
			$table->string("first_name");
			$table->string("last_name");
			$table->integer("department_id");
			$table->integer("hour_cost");
			$table->integer("position_id");
			$table->integer("target_hours");
			$table->integer("over_price");
			$table->integer("user_id")->nullable();
			$table->date("start_job");
			$table->text("responsibilities");
			$table->string("image")->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('position_id')->references('id')->on('positions');
			$table->foreign('department_id')->references('id')->on('departments');
			$table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
};
