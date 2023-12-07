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
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class YourConfessionsExport
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles
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
      'title'          => 'Your Confessions Export',
      'description'    => "Total of your confessions that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Your Confessions',
      'keywords'       => 'Your Confessions,export,spreadsheet',
      'category'       => 'Your Confessions',
    ];
  }

  public function forIdUser(int $idUser)
  {
    $this->idUser = $idUser;

    return $this;
  }

  public function collection()
  {
    return RecConfession::with(["category", "officer.user", "responses", "comments"])
      ->whereIdUser($this->idUser)
      ->latest("updated_at")
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Your Confessions";
  }

  public function headings(): array
  {
    return [
      "Title",
      "Content",
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
      strip_tags($confession->body),
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
