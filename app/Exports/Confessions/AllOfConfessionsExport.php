<?php

namespace App\Exports\Confessions;

use App\Models\RecConfession;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithProperties,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOfConfessionsExport
implements WithProperties, FromCollection, WithHeadings, WithMapping, WithStyles
{
    // ---------------------------------
    // TRAITS
    use Exportable;


    // ---------------------------------
    // PROPERTIES
    protected string $gender;



    // ---------------------------------
    // CORES
    public function properties(): array
    {
        return [
            'title'          => 'All of Confessions Export',
            'description'    => "Total of confessions that have been made on the " . config('app.name'),
            'subject'        => 'Confessions',
            'keywords'       => 'Confessions,export,spreadsheet',
            'category'       => 'Confessions',
        ];
    }

    public function collection()
    {
        return RecConfession::with(["category", "student.user", "officer.user", "responses", "comments"])
            ->latest("updated_at")
            ->get();
    }


    // ---------------------------------
    // UTILITIES
    public function headings(): array
    {
        return [
            "Title",
            "Content",
            "Ownership",
            "Gender",
            "Confession's category",
            "Date of incident",
            "Place",
            "Privacy",
            "Edited",
            "Photo",
            "Status",
            "Assigned to",
            "Response(s)",
            "Comment(s)",
            "Created at",
        ];
    }
    public function map($confession): array
    {
        return [
            $confession->title,
            $confession->body,
            $confession->student->user->full_name,
            $confession->student->user->gender,
            $confession->category->category_name,
            $confession->date,
            $confession->place . " school",
            $confession->privacy,
            $confession->updated_by ? "yes" : 'no',
            $confession->image ? "yes" : 'no',
            $confession->status,
            $confession->officer?->user->full_name ?? '-',
            $confession->responses->count(),
            $confession->comments->count(),
            $confession->created_at->format('j F Y, \a\t H.i'),
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("1")->getFont()->setBold(true);
    }
}