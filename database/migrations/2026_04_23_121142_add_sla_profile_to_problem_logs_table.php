<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->string('sla_profile', 120)->nullable()->after('issue_category');
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            $table->dropColumn('sla_profile');
        });
    }
};
