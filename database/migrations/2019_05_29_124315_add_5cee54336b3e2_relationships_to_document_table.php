<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cee54336b3e2RelationshipsToDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function(Blueprint $table) {
            if (!Schema::hasColumn('documents', 'user_created_id')) {
                $table->integer('user_created_id')->unsigned()->nullable();
                $table->foreign('user_created_id', '309367_5cee4dec4d3c0')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('documents', 'user_updated_id')) {
                $table->integer('user_updated_id')->unsigned()->nullable();
                $table->foreign('user_updated_id', '309367_5cee542fb4f1b')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('documents', function(Blueprint $table) {
            
        });
    }
}
