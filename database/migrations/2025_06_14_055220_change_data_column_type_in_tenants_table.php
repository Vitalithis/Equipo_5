<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataColumnTypeInTenantsTable extends Migration
{
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->json('data')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->longText('data')->nullable()->change();
        });
    }
}
