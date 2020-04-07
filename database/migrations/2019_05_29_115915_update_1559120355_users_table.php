<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1559120355UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
if (!Schema::hasColumn('users', 'name_kh')) {
                $table->string('name_kh');
                }
if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender');
                }
if (!Schema::hasColumn('users', 'dob')) {
                $table->date('dob')->nullable();
                }
if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
                }
if (!Schema::hasColumn('users', 'staff_code')) {
                $table->string('staff_code')->nullable();
                }
if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable();
                }
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
            $table->dropColumn('name_kh');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('phone');
            $table->dropColumn('staff_code');
            $table->dropColumn('photo');
            
        });

    }
}
