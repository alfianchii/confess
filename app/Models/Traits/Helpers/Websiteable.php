<?php

namespace App\Models\Traits\Helpers;

use App\Models\{SettingWebsite, User};

trait Websiteable
{
  // ---------------------------------
  // METHODS
  public function settingWebsiteRules(array $rules, array $data)
  {
    unset($data["_method"], $data["_token"]);
    foreach ($data as $data_key => $data_value) {
      $item = SettingWebsite::where("key", $data_key)->first();
      if (!$item) return view("errors.404");
      if ($item->value === $data_value) unset($rules[$data_key]);
    }
    return $rules;
  }
  public function generateFields(array $credentials, User $user)
  {
    $fields = [];
    foreach ($credentials as $key => $value) {
      $item = SettingWebsite::where("key", $key)->first();

      // Images
      if (strstr($key, "IMAGE"))
        $credentials = $this->file($item->value, $credentials, $key, "website-setting/$key");

      // Fields
      $fields[$key]["value"] = $credentials[$key];
      $fields[$key]["updated_by"] = $user->id_user;
    }
    return $fields;
  }
  public function updateWebsite(array $fields)
  {
    foreach ($fields as $field_key => $field_value) {
      $item = SettingWebsite::where("key", $field_key)->first();
      $item->update($field_value);
    }

    return redirect('/dashboard/website')->withSuccess("Berhasil mengubah pengaturan website!");
  }
}
