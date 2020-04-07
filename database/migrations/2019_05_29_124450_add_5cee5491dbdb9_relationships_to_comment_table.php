<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add5cee5491dbdb9RelationshipsToCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function(Blueprint $table) {
            if (!Schema::hasColumn('comments', 'document_id')) {
                $table->integer('document_id')->unsigned()->nullable();
                $table->foreign('document_id', '309380_5cee50a8e1206')->references('id')->on('documents')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '309380_5cee50a90c357')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'user_created_id')) {
                $table->integer('user_created_id')->unsigned()->nullable();
                $table->foreign('user_created_id', '309380_5cee50a931f98')->references('id')->on('users')->onDelete('cascade');
                }
                if (!Schema::hasColumn('comments', 'user_updated_id')) {
                $table->integer('user_updated_id')->unsigned()->nullable();
                $table->foreign('user_updated_id', '309380_5cee548e2b7a4')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('comments', function(Blueprint $table) {
            
        });
    }
}
