<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'notification_emails',
        'sla_active',
        'response_sla_minutes',
        'resolution_sla_minutes',
        'alert_admin_emails',
        'alert_admin_telegram_chat_ids',
        'alert_spv_emails',
        'alert_spv_telegram_chat_ids',
        'alert_manager_emails',
        'alert_manager_telegram_chat_ids',
    ];

    protected $casts = [
        'sla_active' => 'boolean',
        'response_sla_minutes' => 'integer',
        'resolution_sla_minutes' => 'integer',
    ];


    public function notificationEmailList(): array
    {
        $emails = [];

        if (!empty($this->email)) {
            $emails[] = trim($this->email);
        }

        if (!empty($this->notification_emails)) {
            $parts = preg_split('/[,\n\r]+/', $this->notification_emails) ?: [];
            foreach ($parts as $email) {
                $email = trim($email);
                if ($email !== '') {
                    $emails[] = $email;
                }
            }
        }

        return array_values(array_unique(array_filter($emails)));
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(ProblemLog::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }
}
