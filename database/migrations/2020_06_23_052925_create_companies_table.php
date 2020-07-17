<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_tel')->nullable();
            $table->string('company_email')->nullable();
            $table->bigInteger('company_industry')->unsigned()->nullable();
            $table->bigInteger('sales_id')->unsigned()->nullable();
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('company_industry')->references('id')->on('industries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
