<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'subscriptions', function (Blueprint $table){
            $table->id();
            $table->string('title')->unique();
            $table->float('package_amount')->default(0.00);
            $table->string('interval')->nullable();
            $table->integer('user_limit')->nullable();
            $table->integer('enabled_pre_register')->default(0);
            $table->integer('enabled_logged_history')->default(0);
            $table->timestamps();
        }
        );
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
}
