<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutherizepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autherizepayment', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_id');
        $table->float('amount', 10, 2);
        $table->string('currency');
        $table->string('payment_status');
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
        Schema::dropIfExists('autherizepayment');
    }
}
