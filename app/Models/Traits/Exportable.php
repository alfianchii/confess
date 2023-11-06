<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Validator;

trait Exportable
{
  // ---------------------------------
  // PROPERTIES


  // ---------------------------------
  // MAGIC FUNCTIONS


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
    return substr(md5(now()), 0, 10) . "." . strtolower($type);
  }
  public function exportValidates(array $data)
  {
    return Validator::make($data, $this->getExportRules(), $this->getExportMessages());
  }
}
