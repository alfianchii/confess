<?php

namespace App\Exports\Confessions;

use App\Models\RecConfession;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithProperties,
    WithTitle,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithStrictNullComparison,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOfConfessionsExport
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{
    // ---------------------------------
    // TRAITS
    use Exportable;


    // ---------------------------------
    // CORES
    public function properties(): array
    {
        return [
            'title'          => 'All of Confessions Export',
            'description'    => "Total of confessions that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
            'subject'        => 'Confessions',
            'keywords'       => 'Confessions,export,spreadsheet',
            'category'       => 'Confessions',
        ];
    }

    public function collection()
    {
        return RecConfession::with(["category", "student.user", "officer.user", "responses", "comments", "likes"])
            ->latest("updated_at")
            ->get();
    }


    // ---------------------------------
    // UTILITIES
    public function title(): string
    {
        return "All of Confessions";
    }

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
            "Like(s)",
            "Created at",
        ];
    }

    public function map($confession): array
    {
        return [
            $confession->title,
            strip_tags($confession->body),
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
            $confession->likes->count(),
            $confession->created_at->format('j F Y, \a\t H.i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("1")->getFont()->setBold(true);
    }
}
