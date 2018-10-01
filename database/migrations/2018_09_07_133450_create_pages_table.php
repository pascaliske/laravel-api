<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            // columns
            $table->increments('id');
            $table->string('title');
            $table->string('path');
            $table->text('components')->nullable();
            $table->unsignedInteger('author');
            $table->boolean('published')->default(false);
            $table->timestamp('created')->default(Db::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated')->default(Db::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // indexes
            $table->unique('path');
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
        Schema::dropIfExists('pages');
    }
}
