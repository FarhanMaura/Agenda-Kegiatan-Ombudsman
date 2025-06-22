<?php

namespace App\Exports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AgendaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $division;
    protected $isArchived;

    public function __construct($division, $isArchived = false)
    {
        $this->division = $division;
        $this->isArchived = $isArchived;
    }

    public function collection()
    {
        return Agenda::where('division', $this->division)
                    ->where('is_archived', $this->isArchived)
                    ->orderBy('date', 'asc')
                    ->orderBy('start_time', 'asc')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'Hari',
            'Tanggal',
            'Waktu',
            'Kegiatan',
            'Lembaga',
            'Penanggung Jawab'
        ];
    }

    public function map($agenda): array
    {
        $activities = json_decode($agenda->activity, true) ?? [];
        $activitiesString = implode("\n", $activities);

        return [
            $agenda->day,
            $agenda->date->format('d/m/Y'),
            $agenda->time,
            $activitiesString,
            $agenda->institution,
            $agenda->person_in_charge
        ];
    }
}
