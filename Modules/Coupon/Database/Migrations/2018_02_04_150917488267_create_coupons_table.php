<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Coupon\Enums\DiscountTypeCases;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('code')->unique()->index();
            $table->unsignedDecimal('value', 18, 4)->nullable();
            $table->enum('discount_type', DiscountTypeCases::values());
            $table->unsignedInteger('used')->default(0);
            $table->json("meta")->nullable();
            $table->boolean('is_active');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};