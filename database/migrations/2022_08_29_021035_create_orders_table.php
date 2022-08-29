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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',100);
            $table->foreignId('user_id')->constrained('users');
            $table->tinyInteger('status')->comment('0:CREATED | 1:COLLECTED | 2:IN_STATION | 3:ON_ROUTE | 4:DELIVERED | 5:CANCELED');
            $table->string('origin');
            $table->string('destiny');
            $table->float('total',12,2);
            $table->float('total_weight',8,2)->comment('Kilograms');
            $table->char('size',2)->comment('S:SMALL | M:MEDIUM | L:LARGE');
            $table->tinyInteger('refund')->comment('0:NO | 1:YES')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('orders');
    }
};
