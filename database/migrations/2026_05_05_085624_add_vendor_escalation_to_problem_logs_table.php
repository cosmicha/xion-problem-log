<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_escalated')->default(false);
            $table->timestamp('escalated_at')->nullable();
        });
    }

    public function down(): void {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->dropColumn(['vendor_id','is_escalated','escalated_at']);
        });
    }
};
