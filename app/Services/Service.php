<?php

namespace App\Services;

use App\Models\Traits\{Activeable, Validatory};
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\{Auth, Storage};
use Intervention\Image\Facades\Image;

class Service
{
  // ---------------------------------
  // TRAITS
  use Validatory, Activeable;


  // ---------------------------------
  // PROPERTIES
  const PER_PAGE = 3;
  const HOME_URL = RouteServiceProvider::HOME;
  const DASHBOARD_URL = RouteServiceProvider::DASHBOARD;


  // ---------------------------------
  // METHODS
  public function responseJsonMessage($message, $status = 200)
  {
    return response()->json([
      "message" => $message,
    ], $status);
  }

  public function modify($data, array $credentials, $idUser, string $noun, $url)
  {
    try {
      $oldData = $data->fresh();
      $data->update($credentials);
      $newData = $data->fresh();

      $oldAttributes = $oldData->getAttributes();
      $newAttributes = $newData->getAttributes();

      if (($oldAttributes === $newAttributes))
        return redirect($url)
          ->withInfo("Kamu tidak melakukan editing pada $noun.");

      $data->update(["updated_by" => $idUser]);
    } catch (\Exception $e) {
      return redirect($url)
        ->withErrors($e->getMessage());
    }

    return redirect($url)
      ->withSuccess(ucfirst($noun) . " berhasil disunting!");
  }

  public function file($file, $credentials, $key, $storeUrl)
  {
    if (array_key_exists($key, $credentials)) {
      if ($file) Storage::delete($file);
      $credentials[$key] = $credentials[$key]->store($storeUrl);

      return $credentials;
    }

    return $credentials;
  }

  public function imageCropping($image, $credentials, $key, $storeUrl, $config = [
    "position" => "center",
    "width" => 1200,
    "height" => 1200,
  ])
  {
    if (array_key_exists($key, $credentials)) {
      if ($image) Storage::delete($image);

      $imageOriginalPath = $credentials[$key]->store($storeUrl);
      $credentials[$key] = $imageOriginalPath;
      $croppedImage = Image::make("storage/" . $imageOriginalPath);
      $croppedImage->fit($config["width"], $config["height"], function ($constraint) {
        $constraint->upsize();
      }, $config["position"]);

      Storage::put($imageOriginalPath, $croppedImage->stream());
    } else {
      if ($image) $credentials[$key] = $image;
      else $credentials[$key] = null;
    };

    return $credentials;
  }

  public function slugRules(array $theRules, string $inputSlug, $dataSlug)
  {
    $rules = $theRules;
    unset($rules["slug"]);
    if ($inputSlug !== $dataSlug)
      $rules["slug"] = $theRules["slug"];

    return $rules;
  }
}
