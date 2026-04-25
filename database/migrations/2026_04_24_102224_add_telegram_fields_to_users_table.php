<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'telegram_chat_id')) {
                $table->string('telegram_chat_id')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'telegram_link_code')) {
                $table->string('telegram_link_code')->nullable()->after('telegram_chat_id');
            }
            if (!Schema::hasColumn('users', 'telegram_linked_at')) {
                $table->timestamp('telegram_linked_at')->nullable()->after('telegram_link_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['telegram_chat_id','telegram_link_code','telegram_linked_at'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
