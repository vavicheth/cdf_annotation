<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cee3d99d43eeRelationshipsToDepartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function(Blueprint $table) {
            if (!Schema::hasColumn('departments', 'user_created_id')) {
                $table->integer('user_created_id')->unsigned()->nullable();
                $table->foreign('user_created_id', '309340_5cee3d95c4d3e')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('departments', 'user_updated_id')) {
                $table->integer('user_updated_id')->unsigned()->nullable();
                $table->foreign('user_updated_id', '309340_5cee3d95decaa')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('departments', function(Blueprint $table) {
            
        });
    }
}
