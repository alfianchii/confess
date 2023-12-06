<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\WebsiteService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingWebsiteController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected WebsiteService $websiteService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(WebsiteService $websiteService)
    {
        parent::__construct();
        $this->websiteService = $websiteService;
    }


    // ---------------------------------
    // CORES
    public function edit()
    {
        return $this->websiteService->edit($this->userRole);
    }

    public function update(Request $request)
    {
        return $this->websiteService->update($request, $this->userData, $this->userRole);
    }
}
