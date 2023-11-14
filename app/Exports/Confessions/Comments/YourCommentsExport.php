<?php

namespace App\Exports\Confessions\Comments;

use App\Models\RecConfessionComment;
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

class YourCommentsExport
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
      'title'          => 'Your Comments Export',
      'description'    => "Total of your comments that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Your Comments',
      'keywords'       => 'Your Comments,export,spreadsheet',
      'category'       => 'Your Comments',
    ];
  }

  public function forIdUser(int $idUser)
  {
    $this->idUser = $idUser;

    return $this;
  }

  public function collection()
  {
    return RecConfessionComment::with([
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
    return "Your Comments";
  }
  public function headings(): array
  {
    return [
      "Ownership",
      "Gender",
      "Comment",
      "Privacy",
      "Attachment file",
      "Edited",
      "Created at",
      "Confession's ownership",
      "Confession's title",
      "Confession's category",
      "Confession's status",
    ];
  }
  public function map($comment): array
  {
    return [
      $comment->user->full_name,
      $comment->user->gender,
      strip_tags($comment->comment),
      $comment->privacy,
      $comment->attachment_file ? "yes" : 'no',
      $comment->updated_by ? "yes" : 'no',
      $comment->created_at->format('j F Y, \a\t H.i'),
      $comment->confession->student->user->full_name,
      $comment->confession->title,
      $comment->confession->category->category_name,
      $comment->confession->status,
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
