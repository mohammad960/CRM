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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
			$table->integer("employee_id")->nullable();
			$table->integer("project_id")->nullable();
			$table->string("description")->nullable();
			$table->date("date_day")->nullable();
			$table->timestamp("start_date")->nullable();
			$table->timestamp("end_date")->nullable();
			$table->integer("over_price")->nullable();
			$table->integer("hour_cost")->nullable();
			$table->integer("hours")->default(0);
			$table->string("status")->nullable();
			$table->integer("salary_id")->nullable();
			$table->foreign('employee_id')->references('id')->on('employees');
			$table->foreign('salary_id')->references('id')->on('salaries');
			$table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('tasks');
    }
};
