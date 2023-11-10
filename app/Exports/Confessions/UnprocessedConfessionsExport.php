<?php

namespace App\Exports\Confessions;

use App\Models\RecConfession;
use Maatwebsite\Excel\Concerns\{
  Exportable,
  WithProperties,
  FromCollection,
  WithTitle,
  WithHeadings,
  WithMapping,
  WithStyles,
  WithStrictNullComparison,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UnprocessedConfessionsExport
implements WithProperties, WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // CORES
  public function properties(): array
  {
    return [
      'title'          => 'Unprocessed Confessions Export',
      'description'    => "Total of confessions which handled by you that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Unprocessed Confessions',
      'keywords'       => 'Unprocessed Confessions,export,spreadsheet',
      'category'       => 'Unprocessed Confessions',
    ];
  }

  public function collection()
  {
    return RecConfession::with(["category", "student.user", "responses"])
      ->latest("updated_at")
      ->where("assigned_to", null)
      ->where("status", "unprocess")
      ->orWhere("status", "release")
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Unprocessed Confessions";
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
      "Response(s)",
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
      $confession->responses->count(),
      $confession->created_at->format('j F Y, \a\t H.i'),
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
