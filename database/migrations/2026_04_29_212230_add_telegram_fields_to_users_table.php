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
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'telegram_chat_id')) {
                $table->dropColumn('telegram_chat_id');
            }
            if (Schema::hasColumn('users', 'telegram_link_code')) {
                $table->dropColumn('telegram_link_code');
            }
        });
    }
};
