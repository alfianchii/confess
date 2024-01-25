<?php

namespace App\Models\Traits;

use App\Models\{MasterGuide};

trait Breadcrumbable
{
  // ---------------------------------
  // METHODS
  private function getGuideParent(int $idGuideParent)
  {
    return MasterGuide::where("id_guide", $idGuideParent)->childs()->first();
  }

  private function getBreadcrumbs(MasterGuide $guide, array $breadcrumbs = [])
  {
    array_unshift($breadcrumbs, $guide);

    if ($guide->id_guide_parent) {
      $guide = $this->getGuideParent($guide->id_guide_parent);
      return $this->getBreadcrumbs($guide, $breadcrumbs);
    }

    return $breadcrumbs;
  }

  public function guideBreadcrumbsHTML(MasterGuide $guide, string $element = "")
  {
    $breadcrumbs = $this->getBreadcrumbs($guide);
    return $this->guideBreadcrumbs($breadcrumbs, $element);
  }

  private function guideBreadcrumbs($breadcrumbs, string $element)
  {
    foreach ($breadcrumbs as $breadcrumb)
      $element .= $this->generateBreadcrumbs($breadcrumb);

    return $element;
  }

  private function generateBreadcrumbs(MasterGuide $breadcrumb)
  {
    return $breadcrumb->childs->count() ?
      $this->activeBreadcrumb($breadcrumb) :
      $this->nonActiveBreadcrumb($breadcrumb);
  }

  private function activeBreadcrumb(MasterGuide $guide)
  {
    $url = $this->getGuideURL($guide);

    return "
      <li class='breadcrumb-item active' aria-current='page'>
          <a href='/dashboard/guides/" . $url . "'>$guide->nav_title</a>
      </li>
    ";
  }

  public function nonActiveBreadcrumb(MasterGuide $guide)
  {
    return "
      <li class='breadcrumb-item'>
          $guide->nav_title
      </li>
    ";
  }

  public function getGuideURL(MasterGuide $guide)
  {
    return $guide->childs->count() ? $this->getGuideURL($guide->childs[0]) : $guide->url;
  }
}
