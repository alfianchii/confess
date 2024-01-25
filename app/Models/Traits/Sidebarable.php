<?php

namespace App\Models\Traits;

use App\Models\{MasterGuide};
use Illuminate\Support\Facades\Request;

trait Sidebarable
{
  // ---------------------------------
  // METHODS
  public function getGuides()
  {
    return MasterGuide::childs(true);
  }

  public function guideSidebarHTML($guides, string $element = "")
  {
    return $this->guideSidebar($guides, $element);
  }

  private function guideSidebar($guides, string $element)
  {
    foreach ($guides as $guide)
      $element .= $this->generateSidebar($guide);

    return $element;
  }

  private function generateSidebar(MasterGuide $guide)
  {
    return $guide->childs->count() ?
      $this->sidebarMulti($guide) :
      $this->sidebarSingle($guide);
  }

  private function sidebarMulti(MasterGuide $guide)
  {
    return "
      <li class='submenu-item has-sub {$this->isActiveSidebar($guide)}'>
          <a href='#' class='submenu-link'>$guide->nav_title</a>
          <ul class='submenu submenu-closed'>
              {$this->guideSidebarHTML($guide->childs)}
          </ul>
      </li>
    ";
  }

  private function sidebarSingle(MasterGuide $guide)
  {
    return "
      <li class='submenu-item {$this->isActiveSidebar($guide)}'>
          <a class='submenu-link' href='/dashboard/guides/$guide->url'>$guide->nav_title</a>
      </li>
    ";
  }

  private function isActiveSidebar(MasterGuide $guide)
  {
    return Request::is("dashboard/guides/$guide->url*") ? 'active' : '';
  }
}
