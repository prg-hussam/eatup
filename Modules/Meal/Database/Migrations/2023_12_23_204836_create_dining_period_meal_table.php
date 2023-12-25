<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Meal\Entities\DiningPeriod;
use Modules\Meal\Entities\Meal;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dining_period_meal', function (Blueprint $table) {
            $table->foreignIdFor(DiningPeriod::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Meal::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dining_period_meal');
    }
};