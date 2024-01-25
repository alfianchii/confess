<?php

namespace App\Models\Traits\Helpers;

use Illuminate\Support\Facades\{Validator};
use App\Models\{User, MasterGuide};
use stdClass;

trait Guideable
{
  // ---------------------------------
  // PROPERTIES
  const AVERAGE_READING_SPEED = 200;


  // ---------------------------------
  // METHODS
  public function guideCredentials(User $user, array $credentials)
  {
    $credentials["id_guide_parent"] = MasterGuide::firstWhere("slug", $credentials["id_guide_parent"])->id_guide ?? 0;
    $credentials["reading_time"] = $this->readingTime($credentials["body"]);
    $credentials["url"] =  $this->url($credentials);
    $credentials = $this->timestamps($user, $credentials);

    return $credentials;
  }

  private function url(array $credentials)
  {
    $parent = MasterGuide::firstWhere("id_guide", $credentials["id_guide_parent"]);
    $url = $credentials["slug"];

    if ($parent)
      $url = $parent->url . "/" . $credentials["slug"];

    return $url;
  }

  public function timestamps(User $user, array $credentials, bool $create = true, bool $update = true)
  {
    if ($create) return $this->timestampsCreate($user, $credentials);
    if ($update) return $this->timestampsUpdate($user, $credentials);

    return $this->timestampsCreateAndUpdate($user, $credentials);
  }

  private function timestampsCreate(User $user, array $credentials)
  {
    $credentials["created_by"] = $user->id_user;
    $credentials["created_at"] = now();

    return $credentials;
  }

  private function timestampsUpdate(User $user, array $credentials)
  {
    $credentials["updated_by"] = $user->id_user;
    $credentials["updated_at"] = now();

    return $credentials;
  }

  private function timestampsCreateAndUpdate(User $user, array $credentials)
  {
    $credentials["created_by"] = $user->id_user;
    $credentials["created_at"] = now();
    $credentials["updated_by"] = $user->id_user;
    $credentials["updated_at"] = now();

    return $credentials;
  }

  private function readingTime(string $content)
  {
    $wordCount = str_word_count(strip_tags($content));
    $minutes = $wordCount / self::AVERAGE_READING_SPEED;
    $seconds = (int) floor($minutes * 60);

    return $seconds;
  }

  public function createGuide(array $credentials)
  {
    $status = $credentials["status"];
    $this->validateIfParentHasChild($credentials);

    if ($status === "single")
      return MasterGuide::create($credentials);

    if ($status === "parent") {
      $childCredentials = $credentials;
      $credentials = $this->setParentFields($credentials);
      $childCredentials = $this->setChildFields($credentials, $childCredentials);

      $parent = $this->createGuideParent($credentials);
      $child = $this->createGuideChild($parent, $childCredentials);

      return $child;
    }
  }

  private function validateIfParentHasChild(array $credentials)
  {
    $idGuideParent = $credentials["id_guide_parent"];
    $isParentGuide = $idGuideParent == 0 ? true : false;

    if (!$isParentGuide)
      $this->reassignParentGuide($idGuideParent);
  }

  private function reassignParentGuide($idGuideParent)
  {
    $parentGuide = MasterGuide::firstWhere("id_guide", $idGuideParent);
    $reassignCreds = $parentGuide->toArray();
    $reassignCreds["id_guide_parent"] = $idGuideParent;
    $this->reassignParentFields($parentGuide);

    $reassignGuide = $this->setChildFields($reassignCreds, $reassignCreds);
    MasterGuide::create($reassignGuide);
  }

  private function reassignParentFields(MasterGuide $parentGuide)
  {
    $parentGuide->body = "";
    $parentGuide->title = "";
    $parentGuide->reading_time = 0;
    $parentGuide->save();
  }

  private function setParentFields(array $credentials)
  {
    $credentials["title"] = "";
    $credentials["body"] = "";
    $credentials["reading_time"] = 0;

    return $credentials;
  }

  private function setChildFields(array $credentials, array $childCredentials)
  {
    $childCredentials["nav_title"] = 'Overview';
    $childCredentials["slug"] = 'overview-' . strtolower($credentials["nav_title"]);
    $childCredentials["url"] = $credentials["url"] . '/overview-' . strtolower($credentials["nav_title"]);

    return $childCredentials;
  }

  private function createGuideParent(array $credentials,)
  {
    $guideParent = MasterGuide::create($credentials);

    return $guideParent;
  }

  private function createGuideChild(MasterGuide $parent, array $childCredentials)
  {
    $childCredentials["id_guide_parent"] = $parent->id_guide;
    $guideChild = MasterGuide::create($childCredentials);

    return $guideChild;
  }

  public function createGuideURL(string $url)
  {
    return "/dashboard" . "/" . 'guides/' . $url;
  }

  public function alterGuideChild(User $user, MasterGuide $guide, array $data, array $rules, array $messages)
  {
    unset($rules["id_guide_parent"], $rules["status"]);
    $credentials = Validator::make($data, $rules, $messages)->validate();
    $credentials["reading_time"] = $this->readingTime($credentials["body"]);
    unset($guide->childs);

    return $this->modify($guide, $credentials, $user->id_user, "panduan \"$guide->nav_title\"", "/dashboard/guides/$guide->url");
  }

  public function alterGuideParent(User $user, MasterGuide $guide, array $data, array $rules, array $messages)
  {
    unset($rules["title"], $rules["id_guide_parent"], $rules["status"], $rules["body"]);
    $credentials = Validator::make($data, $rules, $messages)->validate();
    $credentials["reading_time"] = $this->readingTime($credentials["body"]);

    if (array_key_exists("slug", $credentials))
      $guide = $this->alterGuideSlug($guide, $credentials);
    unset($guide->childs);

    return $this->modify($guide, $credentials, $user->id_user, "panduan \"$guide->nav_title\"", "/dashboard/setting/guides");
  }

  public function alterGuideSlug($guide, array $credentials)
  {
    $guide->url = $credentials["slug"];
    $guide->childs->each(function ($child) use ($guide, $credentials) {
      if ($child->childs->count()) $this->alterGuideSlug($child, $credentials);
      else $this->alterGuideChildSlug($guide, $child, $credentials);
    });

    return $guide;
  }

  private function alterGuideChildSlug(MasterGuide $guide, MasterGuide $child, array $credentials)
  {
    $url = str_replace($guide->slug, $credentials["slug"], $child->url);
    $child->url = $url;
    unset($child->childs);
    $child->update();
  }
}
