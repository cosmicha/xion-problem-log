<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('problem_logs', 'root_cause_category')) {
                $table->string('root_cause_category')->nullable();
            }

            if (!Schema::hasColumn('problem_logs', 'sla_responsibility')) {
                $table->string('sla_responsibility')->nullable();
            }

            if (!Schema::hasColumn('problem_logs', 'cost_responsibility')) {
                $table->string('cost_responsibility')->nullable();
            }

            if (!Schema::hasColumn('problem_logs', 'root_cause_note')) {
                $table->text('root_cause_note')->nullable();
            }

            if (!Schema::hasColumn('problem_logs', 'preventive_action')) {
                $table->text('preventive_action')->nullable();
            }

            if (!Schema::hasColumn('problem_logs', 'customer_misuse')) {
                $table->boolean('customer_misuse')->default(false);
            }

            if (!Schema::hasColumn('problem_logs', 'sla_excluded')) {
                $table->boolean('sla_excluded')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('problem_logs', function (Blueprint $table) {
            foreach ([
                'root_cause_category',
                'sla_responsibility',
                'cost_responsibility',
                'root_cause_note',
                'preventive_action',
                'customer_misuse',
                'sla_excluded',
            ] as $column) {
                if (Schema::hasColumn('problem_logs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
