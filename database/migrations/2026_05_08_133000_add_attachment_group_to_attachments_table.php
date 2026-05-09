<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('attachments') && !Schema::hasColumn('attachments', 'attachment_group')) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->string('attachment_group')->default('general')->after('attachable_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('attachments') && Schema::hasColumn('attachments', 'attachment_group')) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->dropColumn('attachment_group');
            });
        }
    }
};
