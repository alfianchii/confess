<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\{Validator};

trait Importable
{
  // ---------------------------------
  // METHODS
  public function getImportRules()
  {
    return [
      "file" => ["required", "file", "mimes:xlsx", "max:10240"],
      "table" => ['required'],
    ];
  }

  public function getImportMessages()
  {
    return [
      "file.required" => "File tidak boleh kosong.",
      "file.file" => "File harus berupa :file.",
      "file.mimes" => "File harus dengan format: :values.",
      "file.max" => "File tidak boleh lebih dari :max KiB.",
      "table.required" => "Data table tidak boleh kosong.",
    ];
  }

  public function importValidates(array $data)
  {
    return Validator::make($data, $this->getImportRules(), $this->getImportMessages());
  }

  public function imports($instance, $file, $writterType, string $message)
  {
    $instance->import($file, $writterType);
    return back()->withSuccess($message);
  }
}
