<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cee49e853505RelationshipsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            if (!Schema::hasColumn('users', 'title_id')) {
                $table->integer('title_id')->unsigned()->nullable();
                $table->foreign('title_id', '309291_5cee49e367281')->references('id')->on('titles')->onDelete('cascade');
                }
                if (!Schema::hasColumn('users', 'position_id')) {
                $table->integer('position_id')->unsigned()->nullable();
                $table->foreign('position_id', '309291_5cee49e384ff1')->references('id')->on('positions')->onDelete('cascade');
                }
                if (!Schema::hasColumn('users', 'department_id')) {
                $table->integer('department_id')->unsigned()->nullable();
                $table->foreign('department_id', '309291_5cee49e3a36fd')->references('id')->on('departments')->onDelete('cascade');
                }
                if (!Schema::hasColumn('users', 'role_id')) {
                $table->integer('role_id')->unsigned()->nullable();
                $table->foreign('role_id', '309291_5cee28375555a')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::table('users', function(Blueprint $table) {
            
        });
    }
}
