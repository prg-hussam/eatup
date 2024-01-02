<?php

use Modules\Meal\Entities\Meal;
use Modules\Meal\Entities\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_menu', function (Blueprint $table) {
            $table->foreignIdFor(Meal::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Menu::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_menu');
    }
};
