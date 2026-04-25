<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('problem_logs', 'response_sla_alert_sent_at')) {
                $table->timestamp('response_sla_alert_sent_at')->nullable()->after('response_sla_breached');
            }
            if (!Schema::hasColumn('problem_logs', 'resolution_sla_alert_sent_at')) {
                $table->timestamp('resolution_sla_alert_sent_at')->nullable()->after('resolution_sla_breached');
            }
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            foreach ([
                'response_sla_alert_sent_at',
                'resolution_sla_alert_sent_at',
            ] as $col) {
                if (Schema::hasColumn('problem_logs', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
