<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('log_details')->nullable();
            $table->string('controller_name')->nullable();
            $table->string('function_name')->nullable();
            $table->string('location')->default("Bangladesh");
            $table->string('ip_address')->nullable();
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
        Schema::dropIfExists('activity_log');
    }
}
