<?php

namespace App\Exports\Users;

use App\Models\HistoryLogin;
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

class HistoryLoginsExport
implements WithProperties, WithTitle, FromCollection, WithHeadings, WithMapping, WithStyles
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
      'title'          => 'History Logins Export',
      'description'    => "Total of history logins who have registered on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'History Logins',
      'keywords'       => 'History Logins,export,spreadsheet',
      'category'       => 'History Logins',
    ];
  }

  public function collection()
  {
    return HistoryLogin::latest()->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "History Logins";
  }
  public function headings(): array
  {
    return [
      'Date',
      'Username',
      'Attempt result',
      'Operating system',
      'Internet protocol',
      'User agent',
      'Browser',
    ];
  }
  public function map($login): array
  {
    return [
      $login->created_at->format('j F Y, \a\t H.i'),
      $login->username,
      $login->attempt_result === "Y" ? "yes" : "no",
      $login->operating_system,
      $login->remote_address,
      $login->user_agent,
      $login->browser,
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
