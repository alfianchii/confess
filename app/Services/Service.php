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
      // Get the new and old of $data
      $oldData = $data->fresh();
      $data->update($credentials);
      $newData = $data->fresh();

      // Get the old and new versions of the model as arrays
      $oldAttributes = $oldData->getAttributes();
      $newAttributes = $newData->getAttributes();

      // Compare the arrays to see if any attributes have changed
      if (($oldAttributes === $newAttributes))
        // The instance of the $data record has not been updated
        return redirect($url)
          ->withInfo("Kamu tidak melakukan editing pada $noun.");

      // Update by
      $data->update(["updated_by" => $idUser]);
    } catch (\Exception $e) {
      return redirect($url)
        ->withErrors($e->getMessage());
    }

    // The instance of the $data record has been updated
    return redirect($url)
      ->withSuccess(ucfirst($noun) . " berhasil disunting!");
  }

  public function file($file, $credentials, $key, $storeUrl)
  {
    // File
    if (array_key_exists($key, $credentials)) {
      // If the data has an file, delete it and replace it with the new one
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
      // If the data has an image, delete it and replace it with the new one
      if ($image) Storage::delete($image);

      // Store original image
      $imageOriginalPath = $credentials[$key]->store($storeUrl);

      // Set path
      $credentials[$key] = $imageOriginalPath;

      // Open image using Intervention Image
      $croppedImage = Image::make("storage/" . $imageOriginalPath);

      // Crop the image to a square with a width of pixels
      $croppedImage->fit($config["width"], $config["height"], function ($constraint) {
        $constraint->upsize();
      }, $config["position"]);

      // Replace original image with cropped image
      Storage::put($imageOriginalPath, $croppedImage->stream());
    } else {
      // If the user has an image, keep it
      if ($image) $credentials[$key] = $image;
      // If the user has no image, set it to null
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

  public function breakUserSession()
  {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
  }
}
