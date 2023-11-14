<?php

namespace App\Exports\Users\Templates;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
  Exportable,
  WithProperties,
  FromCollection,
  WithTitle,
  WithHeadings,
  WithMapping,
  WithCustomValueBinder,
  WithStyles,
};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\{
  DefaultValueBinder,
  Cell,
  DataType,
};

class UsersExport extends DefaultValueBinder
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithCustomValueBinder, WithStyles
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
      'title'          => 'Template Users Export',
      'description'    => "Template users on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => 'Users',
      'keywords'       => 'Users,export,spreadsheet',
      'category'       => 'Users',
    ];
  }

  public function collection()
  {
    return new Collection([
      [
        "full_name" => "Muhammad Alfian",
        "username" => "alfian",
        "nik" => "8901234561234567",
        "role" => "student",
        "unique" => "1278901234567834",
        "gender" => "L",
        "email" => "alfian.dev@gmail.com",
        "flag_active" => "N",
        "password" => "officer123",
      ],
      [
        "full_name" => "Munaa Raudhatul Jannah",
        "username" => "munaa",
        "nik" => "4567856123901234",
        "role" => "officer",
        "unique" => "678378934545601212",
        "gender" => "P",
        "email" => "nana@gmail.com",
        "flag_active" => "Y",
        "password" => "officer321",
      ],
    ]);
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Template Users";
  }
  public function headings(): array
  {
    return [
      "Full name",
      "Username",
      "NIK",
      "Role",
      "Unique",
      "Gender",
      "Email",
      "Active",
      "Password",
    ];
  }
  public function map($data): array
  {
    return [
      $data["full_name"],
      $data["username"],
      $data["nik"],
      $data["role"],
      $data["unique"],
      $data["gender"],
      $data["email"],
      $data["flag_active"],
      $data["password"],
    ];
  }
  public function bindValue(Cell $cell, $value)
  {
    // Convert numeric into text
    if (is_numeric($value)) {
      $cell->setValueExplicit($value, DataType::TYPE_STRING);
      return true;
    }

    // Return default behavior
    return parent::bindValue($cell, $value);
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
