<?php

namespace App\Exports\Confessions\Likes;

use App\Models\HistoryConfessionLike;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithProperties,
    FromCollection,
    WithTitle,
    WithHeadings,
    WithMapping,
    WithStyles,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOfLikesExport
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles
{
    // ---------------------------------
    // TRAITS
    use Exportable;


    // ---------------------------------
    // CORES
    public function properties(): array
    {
        return [
            'title'          => 'All of Likes Export',
            'description'    => "Total of likes that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
            'subject'        => 'Likes',
            'keywords'       => 'Likes,export,spreadsheet',
            'category'       => 'Likes',
        ];
    }

    public function collection()
    {
        return HistoryConfessionLike::with([
            "confession.category",
            "confession.student.user",
            "user",
        ])
            ->latest()
            ->get();
    }


    // ---------------------------------
    // UTILITIES
    public function title(): string
    {
        return "All of Likes";
    }

    public function headings(): array
    {
        return [
            "Ownership",
            "Gender",
            "Created at",
            "Confession's ownership",
            "Confession's title",
            "Confession's category",
            "Confession's status",
        ];
    }

    public function map($like): array
    {
        return [
            $like->user->full_name,
            $like->user->gender,
            $like->created_at->format('j F Y, \a\t H.i'),
            $like->confession->student->user->full_name,
            $like->confession->title,
            $like->confession->category->category_name,
            $like->confession->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("1")->getFont()->setBold(true);
    }
}