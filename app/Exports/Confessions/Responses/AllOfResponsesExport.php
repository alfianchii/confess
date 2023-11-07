<?php

namespace App\Exports\Confessions\Responses;

use App\Models\HistoryConfessionResponse;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithProperties,
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOfResponsesExport
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
            'title'          => 'All of Responses Export',
            'description'    => "Total of responses that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
            'subject'        => 'Responses',
            'keywords'       => 'Responses,export,spreadsheet',
            'category'       => 'Responses',
        ];
    }

    public function collection()
    {
        return HistoryConfessionResponse::with([
            "confession.category",
            "confession.student.user",
            "user",
        ])
            ->where("history_confession_responses.system_response", "N")
            ->latest()
            ->get();
    }


    // ---------------------------------
    // UTILITIES
    public function headings(): array
    {
        return [
            "Ownership",
            "Gender",
            "Response",
            "Attachment file",
            "Edited",
            "Created at",
            "Confession's ownership",
            "Confession's title",
            "Confession's category",
            "Confession's status",
        ];
    }
    public function map($response): array
    {
        return [
            $response->user->full_name,
            $response->user->gender,
            strip_tags($response->response),
            $response->attachment_file ? "yes" : 'no',
            $response->updated_by ? "yes" : 'no',
            $response->image ? "yes" : 'no',
            $response->created_at->format('j F Y, \a\t H.i'),
            $response->confession->student->user->full_name,
            $response->confession->title,
            $response->confession->category->category_name,
            $response->confession->status,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle("1")->getFont()->setBold(true);
    }
}