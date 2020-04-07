<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1559121383DocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('documents')) {
            Schema::create('documents', function (Blueprint $table) {
                $table->increments('id');
                $table->string('letter_code');
                $table->string('code_in');
                $table->string('document_code')->nullable();
                $table->string('oranization')->nullable();
                $table->string('description')->nullable();
                $table->tinyInteger('submit')->nullable()->default('0');
                $table->string('user_updated')->nullable();
                
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
