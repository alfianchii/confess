<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\{Validator};

trait Exportable
{
  // ---------------------------------
  // METHODS
  public function getExportRules()
  {
    return [
      "table" => ['required'],
      "type" => ['required'],
    ];
  }

  public function getExportMessages()
  {
    return [
      "table.required" => "Data table tidak boleh kosong.",
      "type.required" => "Tipe dari exporting tidak boleh kosong",
    ];
  }

  public function getExportFileName(string $type)
  {
    return now()->format("Y_m_d_His") . "." . strtolower($type);
  }

  public function exportValidates(array $data)
  {
    return Validator::make($data, $this->getExportRules(), $this->getExportMessages());
  }

  public function getWritterType(string $ext)
  {
    return constant("\Maatwebsite\Excel\Excel::" . $ext);
  }

  public function exports($instance, string $fileName, $writterType)
  {
    return $instance->download($fileName, $writterType);
  }
}
