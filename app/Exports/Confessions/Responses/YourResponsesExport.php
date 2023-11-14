<?php

namespace App\Exports\Confessions\Responses;

use App\Models\HistoryConfessionResponse;
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

class YourResponsesExport
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
      'title'          => 'Your Responses Export',
      'description'    => "Total of your responses that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Your Responses',
      'keywords'       => 'Your Responses,export,spreadsheet',
      'category'       => 'Your Responses',
    ];
  }

  public function forIdUser(int $idUser)
  {
    $this->idUser = $idUser;

    return $this;
  }

  public function collection()
  {
    return HistoryConfessionResponse::with([
      "confession.category",
      "confession.student.user",
      "user",
    ])
      ->where("history_confession_responses.system_response", "N")
      ->whereIdUser($this->idUser)
      ->latest()
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Your Responses";
  }
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
