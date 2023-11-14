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

class ConfessionsHandledByYouExport
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // PROPERTIES
  protected int $idUser;


  // ---------------------------------
  // CORES
  public function properties(): array
  {
    return [
      'title'          => 'Confessions Handled by You Export',
      'description'    => "Total of confessions which handled by you that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Confessions Handled by You',
      'keywords'       => 'Confessions Handled by You,export,spreadsheet',
      'category'       => 'Confessions Handled by You',
    ];
  }

  public function forAssignedTo(int $idUser)
  {
    $this->idUser = $idUser;

    return $this;
  }

  public function collection()
  {
    return RecConfession::with(["category", "student.user", "officer.user", "responses", "comments"])
      ->latest("updated_at")
      ->where("status", "process")
      ->whereAssignedTo($this->idUser)
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Confessions Handled by You";
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
      $confession->created_at->format('j F Y, \a\t H.i'),
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
