<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = config('permission.table_names');
        $columns = config('permission.column_names');

        Schema::create($tables['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tables['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tables['model_has_permissions'], function (Blueprint $table) use ($tables, $columns) {
            $table->unsignedInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columns['model_morph_key']);
            $table->index([$columns['model_morph_key'], 'model_type', ]);

            $table->foreign('permission_id')
                ->references('id')
                ->on($tables['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columns['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tables['model_has_roles'], function (Blueprint $table) use ($tables, $columns) {
            $table->unsignedInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columns['model_morph_key']);
            $table->index([$columns['model_morph_key'], 'model_type', ]);

            $table->foreign('role_id')
                ->references('id')
                ->on($tables['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columns['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tables['role_has_permissions'], function (Blueprint $table) use ($tables) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tables['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tables['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);

            app('cache')->forget('spatie.permission.cache');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = config('permission.table_names');

        Schema::drop($tables['role_has_permissions']);
        Schema::drop($tables['model_has_roles']);
        Schema::drop($tables['model_has_permissions']);
        Schema::drop($tables['roles']);
        Schema::drop($tables['permissions']);
    }
}
