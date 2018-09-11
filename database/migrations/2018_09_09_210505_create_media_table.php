<?php

use Illuminate\Support\Facades\Db;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            // columns
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('path');
            $table->string('type');
            $table->unsignedInteger('author');
            $table->boolean('optimized')->default(false);
            $table->timestamp('created')->default(Db::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated')->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // indexes
            $table
                ->foreign('author')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
