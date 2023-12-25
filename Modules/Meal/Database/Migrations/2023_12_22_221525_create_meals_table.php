<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Category\Entities\Category;
use Modules\Meal\Entities\DiningPeriod;
use Modules\Meal\Enums\MealType;
use Modules\Meal\Enums\MealUnit;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->enum('type', MealType::values());
            $table->enum('unit', MealUnit::values());
            $table->unsignedDouble('calories');
            $table->unsignedInteger('min_qty');
            $table->unsignedInteger('max_qty');
            $table->unsignedDouble('protein_calories_per_unit');
            $table->unsignedDouble('carbs_calories_per_unit');
            $table->unsignedDouble('fat_calories_per_unit');
            $table->unsignedDouble('sugars_calories_per_unit');
            $table->boolean('is_active')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
};