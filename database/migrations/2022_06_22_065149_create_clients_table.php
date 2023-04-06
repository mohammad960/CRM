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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
			$table->string("compnay_name")->nullable();
			$table->string("country")->nullable();
			$table->string("working_domain")->nullable();
			$table->string("company_phone")->nullable();
			$table->string("first_name")->nullable();
			$table->string("last_name")->nullable();
			$table->string("position")->nullable();
			$table->string("phone")->nullable();
			$table->string("image")->nullable();
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
        Schema::dropIfExists('clients');
    }
};
