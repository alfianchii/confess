<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\GuideService;
use App\Http\Controllers\Controller;
use App\Models\{MasterGuide};
use Illuminate\Http\Request;

class MasterGuideController extends Controller
{
  // ---------------------------------
  // PROPERTIES
  protected GuideService $guideService;


  // ---------------------------------
  // MAGIC FUNCTIONS
  public function __construct(GuideService $guideService)
  {
    parent::__construct();
    $this->guideService = $guideService;
  }


  // ---------------------------------
  // CORES
  public function index()
  {
    return $this->guideService->index($this->userRole);
  }

  public function create()
  {
    return $this->guideService->create($this->userRole);
  }

  public function store(Request $request)
  {
    return $this->guideService->store($request, $this->userData, $this->userRole);
  }

  public function show(MasterGuide $guide)
  {
    return $this->guideService->show($guide);
  }

  public function edit(MasterGuide $guide)
  {
    return $this->guideService->edit($this->userRole, $guide);
  }

  public function update(Request $request, MasterGuide $guide)
  {
    return $this->guideService->update($request, $this->userData, $this->userRole, $guide);
  }

  public function destroy(string $slug)
  {
    return $this->guideService->destroy($this->userRole, $slug);
  }


  // ---------------------------------
  // UTILITIES
  public function checkSlug(Request $request)
  {
    return $this->guideService->checkSlug($request, $this->userRole);
  }
}
