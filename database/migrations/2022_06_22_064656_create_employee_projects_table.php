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
        Schema::create('employee_project', function (Blueprint $table) {
            $table->id();
			$table->integer("employee_id");
			$table->integer("project_id");
			$table->integer("hours")->default(0);
			$table->integer("expected_hours")->default(0);
			$table->integer("backup_hours")->default(0);
			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('employee_projects');
    }
};
