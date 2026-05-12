<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            if (!Schema::hasColumn('devices', 'current_location_id')) {
                $table->foreignId('current_location_id')->nullable()->constrained('inventory_locations')->nullOnDelete();
            }

            if (!Schema::hasColumn('devices', 'asset_status')) {
                $table->string('asset_status')->default('available');
            }

            if (!Schema::hasColumn('devices', 'ownership_type')) {
                $table->string('ownership_type')->nullable();
            }

            if (!Schema::hasColumn('devices', 'custody_type')) {
                $table->string('custody_type')->nullable();
            }
        });
    }

    public function down(): void
    {
        //
    }
};
