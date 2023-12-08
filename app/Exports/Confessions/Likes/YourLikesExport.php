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

class YourLikesExport
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
      'title'          => 'Your Likes Export',
      'description'    => "Total of your likes that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Your Likes',
      'keywords'       => 'Your Likes,export,spreadsheet',
      'category'       => 'Your Likes',
    ];
  }

  public function forIdUser(int $idUser)
  {
    $this->idUser = $idUser;

    return $this;
  }

  public function collection()
  {
    return HistoryConfessionLike::with([
      "confession.category",
      "confession.student.user",
      "user",
    ])
      ->whereIdUser($this->idUser)
      ->latest()
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Your Likes";
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
