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
        Schema::create('gen_quotation_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prospect_id')->nullable();
            $table->unsignedBigInteger('work_name_id')->nullable();
            $table->string('area')->nullable();
            $table->date('deleted_date')->nullable();
            $table->timestamps();
            $table->foreign('prospect_id')->references('id')->on('prospects')->onDelete('SET NULL');
            $table->foreign('work_name_id')->references('id')->on('work_names')->onDelete('SET NULL');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generate_calculation');
    }
};
