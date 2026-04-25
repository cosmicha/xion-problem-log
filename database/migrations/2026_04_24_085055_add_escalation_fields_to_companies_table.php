<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'alert_admin_emails')) {
                $table->text('alert_admin_emails')->nullable()->after('notification_emails');
            }
            if (!Schema::hasColumn('companies', 'alert_admin_telegram_chat_ids')) {
                $table->text('alert_admin_telegram_chat_ids')->nullable()->after('alert_admin_emails');
            }
            if (!Schema::hasColumn('companies', 'alert_spv_emails')) {
                $table->text('alert_spv_emails')->nullable()->after('alert_admin_telegram_chat_ids');
            }
            if (!Schema::hasColumn('companies', 'alert_spv_telegram_chat_ids')) {
                $table->text('alert_spv_telegram_chat_ids')->nullable()->after('alert_spv_emails');
            }
            if (!Schema::hasColumn('companies', 'alert_manager_emails')) {
                $table->text('alert_manager_emails')->nullable()->after('alert_spv_telegram_chat_ids');
            }
            if (!Schema::hasColumn('companies', 'alert_manager_telegram_chat_ids')) {
                $table->text('alert_manager_telegram_chat_ids')->nullable()->after('alert_manager_emails');
            }
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            foreach ([
                'alert_admin_emails',
                'alert_admin_telegram_chat_ids',
                'alert_spv_emails',
                'alert_spv_telegram_chat_ids',
                'alert_manager_emails',
                'alert_manager_telegram_chat_ids',
            ] as $col) {
                if (Schema::hasColumn('companies', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
