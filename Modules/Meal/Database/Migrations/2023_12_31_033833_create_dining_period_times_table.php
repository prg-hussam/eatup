<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Meal\Entities\DiningPeriod;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dining_period_times', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DiningPeriod::class)->constrained()->cascadeOnDelete();
            $table->time('from');
            $table->time('to');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('dining_period_times');
    }
};
