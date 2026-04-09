<?php

namespace App\Exports;

use App\Models\ProblemLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProblemLogsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ProblemLog::orderBy('id', 'desc')->get([
            'id',
            'ticket_number',
            'title',
            'description',
            'status',
            'priority',
            'engineer_name',
            'opened_at',
            'in_progress_at',
            'closed_at',
            'close_note',
            'created_at',
            'updated_at',
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ticket Number',
            'Title',
            'Description',
            'Status',
            'Priority',
            'Engineer Name',
            'Opened At',
            'In Progress At',
            'Closed At',
            'Close Note',
            'Created At',
            'Updated At',
        ];
    }
}
