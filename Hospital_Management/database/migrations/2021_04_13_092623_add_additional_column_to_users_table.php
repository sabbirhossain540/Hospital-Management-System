<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_no')->after('role')->nullable(true);
            $table->longText('address')->after('mobile_no')->nullable(true);
            $table->string('degree')->after('address')->nullable(true);
            $table->string('joining_date')->after('degree')->nullable(true);
            $table->string('doctor_specialist')->after('joining_date')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
