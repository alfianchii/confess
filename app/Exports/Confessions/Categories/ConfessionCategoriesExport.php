<?php

namespace App\Exports\Confessions\Categories;

use App\Models\MasterConfessionCategory;
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

class ConfessionCategoriesExport
implements WithProperties, FromCollection, WithTitle, WithHeadings, WithMapping, WithStyles, WithStrictNullComparison
{
  // ---------------------------------
  // TRAITS
  use Exportable;


  // ---------------------------------
  // CORES
  public function properties(): array
  {
    return [
      'title'          => "Confession's Categories Export",
      'description'    => "Total of confession's categories that have been made on the " . config('web_config')['TEXT_WEB_TITLE'],
      'subject'        => "Confession's Categories",
      'keywords'       => "Confession's Categories,export,spreadsheet",
      'category'       => "Confession's Categories",
    ];
  }

  public function collection()
  {
    return MasterConfessionCategory::with(["confessions"])
      ->orderBy("category_name", "asc")
      ->get();
  }


  // ---------------------------------
  // UTILITIES
  public function title(): string
  {
    return "Confession's Categories";
  }

  public function headings(): array
  {
    return [
      "Name",
      "Description",
      "Confession(s)",
      "Edited",
      "Photo",
      "Active",
      "Created at",
    ];
  }

  public function map($category): array
  {
    return [
      $category->category_name,
      strip_tags($category->description),
      $category->confessions->count(),
      $category->updated_by ? "yes" : 'no',
      $category->image ? "yes" : 'no',
      $category->flag_active === "Y" ? "yes" : 'no',
      $category->created_at->format('j F Y, \a\t H.i'),
    ];
  }

  public function styles(Worksheet $sheet)
  {
    $sheet->getStyle("1")->getFont()->setBold(true);
  }
}
