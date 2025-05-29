<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('role_has_permissions') && !Schema::hasColumn('role_has_permissions', 'cliente_id')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('cliente_id')->nullable()->after('role_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('role_has_permissions') && Schema::hasColumn('role_has_permissions', 'cliente_id')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->dropColumn('cliente_id');
            });
        }
    }
};
