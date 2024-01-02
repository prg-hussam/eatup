<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Core\Enums\PaymentStatus;
use Modules\Coupon\Entities\Coupon;
use Modules\Subscription\Entities\Plan;
use Modules\User\Entities\Customer;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Plan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Coupon::class)->nullable()->index();
            $table->dateTime('ends_at');
            $table->dateTime('starts_at');
            $table->unsignedDecimal('discount', 18, 4);
            $table->unsignedDecimal('total', 18, 4)->nullable();
            $table->unsignedDecimal('sub_total', 18, 4)->nullable();
            $table->unsignedDecimal('tax', 18, 4)->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', PaymentStatus::values())->nullable();
            $table->string('currency')->nullable();
            $table->unsignedDecimal('currency_rate', 18, 4)->default(1);
            $table->string('locale')->nullable();

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
        Schema::dropIfExists('subscriptions');
    }
};