<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionCmsRoleCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('permission_cms_role_cms', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');$table->foreign('permission_id')
                ->references('id')
                ->on('permission_cms')
                ->onDelete('cascade');$table->foreign('role_id')
                ->references('id')
                ->on('roles_cms')
                ->onDelete('cascade');$table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_cms_role_cms');
    }
}
