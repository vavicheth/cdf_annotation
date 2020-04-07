<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1559121607DocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            if(Schema::hasColumn('documents', 'description')) {
                $table->dropColumn('description');
            }
            
        });
Schema::table('documents', function (Blueprint $table) {
            
if (!Schema::hasColumn('documents', 'description')) {
                $table->text('description')->nullable();
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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('description');
            
        });
Schema::table('documents', function (Blueprint $table) {
                        $table->string('description')->nullable();
                
        });

    }
}
