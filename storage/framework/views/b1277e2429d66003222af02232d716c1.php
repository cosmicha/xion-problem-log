<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Notification</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f4f7fb;color:#0f172a;">
    <div style="max-width:640px;margin:30px auto;background:#ffffff;border:1px solid #dbe3ef;border-radius:18px;overflow:hidden;">
        <div style="padding:24px 28px;background:linear-gradient(135deg,#0f172a,#1d4ed8);color:#ffffff;">
            <div style="font-size:12px;letter-spacing:.12em;text-transform:uppercase;opacity:.85;">Ticketing System</div>
            <h1 style="margin:10px 0 0;font-size:24px;"><?php echo e($eventTitle); ?></h1>
        </div>

        <div style="padding:28px;">
            <p style="margin:0 0 18px;line-height:1.7;"><?php echo e($eventMessage); ?></p>

            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse:collapse;">
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;width:180px;"><strong>Ticket</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e($problemLog->ticket_number ?: '-'); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><strong>Title</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e($problemLog->title); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><strong>Company</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e(optional($problemLog->company)->name ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><strong>Status</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e($problemLog->status); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><strong>Priority</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e($problemLog->priority); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><strong>Engineer</strong></td>
                    <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;"><?php echo e(optional($problemLog->assignedEngineer)->name ?? $problemLog->engineer_name ?? '-'); ?></td>
                </tr>
                <tr>
                    <td style="padding:10px 0;vertical-align:top;"><strong>Description</strong></td>
                    <td style="padding:10px 0;line-height:1.7;"><?php echo e($problemLog->description); ?></td>
                </tr>
            </table>

            <div style="margin-top:24px;">
                <a href="<?php echo e(config('app.url') . '/problem-logs/' . $problemLog->id); ?>"
                   style="display:inline-block;padding:12px 18px;background:#2563eb;color:#ffffff;text-decoration:none;border-radius:12px;font-weight:700;">
                    Open Ticket
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/macbookair/Sites/xion-local/resources/views/emails/ticket-event.blade.php ENDPATH**/ ?>