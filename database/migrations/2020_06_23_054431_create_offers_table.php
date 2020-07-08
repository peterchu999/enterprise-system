<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('status')->nullable();
            $table->string('information',300);
            $table->bigInteger('sales_id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->string('offer_date');
            $table->string('purchase_order')->nullable();
            $table->bigInteger('offer_number')->unsigned()->nullable();

            $table->foreign('sales_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('offer_number')->references('id')->on('offer_counters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
