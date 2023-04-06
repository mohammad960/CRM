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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
			$table->string("project_name")->nullable();
			$table->date("start_date")->nullable();
			$table->date("end_date")->nullable();
			$table->date("end_admin_date")->nullable();
			$table->integer("price")->default(0);
			$table->integer("expected_hours")->default(0);
			$table->integer("backup_hours")->default(0);
			$table->string("status")->nullable();
			$table->string("image")->nullable();
			$table->integer("client_id")->nullable();
			$table->integer("currency_id")->nullable();
			$table->integer("admin_hours")->default(0);
			$table->boolean("set_project")->default(false);
			$table->foreign('client_id')->references('id')->on('clients');
			$table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('quotations');
    }
};
