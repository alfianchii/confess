<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MasterConfessionCategory;
use App\Services\Dashboard\ConfessionCategoryService;
use Illuminate\Http\Request;

class MasterConfessionCategoryController extends Controller
{
    // ---------------------------------
    // TRAITS


    // ---------------------------------
    // PROPERTIES
    protected ConfessionCategoryService $confessionCategoryService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(ConfessionCategoryService $confessionCategoryService)
    {
        parent::__construct();
        $this->confessionCategoryService = $confessionCategoryService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->confessionCategoryService->index($this->userData, $this->userRole);
    }

    public function create()
    {
        return $this->confessionCategoryService->create($this->userRole);
    }

    public function store(Request $request)
    {
        return $this->confessionCategoryService->store($request, $this->userData, $this->userRole);
    }

    public function edit(MasterConfessionCategory $confessionCategory)
    {
        return $this->confessionCategoryService->edit($this->userRole, $confessionCategory);
    }

    public function update(Request $request, MasterConfessionCategory $confessionCategory)
    {
        return $this->confessionCategoryService->update($request, $this->userData, $this->userRole, $confessionCategory);
    }

    public function destroy(string $slug)
    {
        return $this->confessionCategoryService->destroy($this->userData, $this->userRole, $slug);
    }

    public function export(Request $request)
    {
        return $this->confessionCategoryService->export($request, $this->userRole);
    }


    // ---------------------------------
    // UTILITIES
    public function checkSlug(Request $request)
    {
        return $this->confessionCategoryService->checkSlug($request, $this->userRole);
    }
    public function destroyImage(string $slug)
    {
        return $this->confessionCategoryService->destroyImage($this->userData, $this->userRole, $slug);
    }

    public function activate(string $slug)
    {
        return $this->confessionCategoryService->activate($this->userData, $this->userRole, $slug);
    }
}
