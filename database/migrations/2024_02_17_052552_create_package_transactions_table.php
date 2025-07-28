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
        Schema::create('package_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('subscription_id')->default(0);
            $table->string('subscription_transactions_id')->unique();
            $table->float('amount')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('holder_name',100)->nullable();
            $table->string('card_number',10)->nullable();
            $table->string('card_expiry_month',10)->nullable();
            $table->string('card_expiry_year',10)->nullable();
            $table->string('receipt')->nullable();
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
        Schema::dropIfExists('package_transactions');
    }
};
