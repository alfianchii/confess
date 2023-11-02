<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\ResponseService;
use App\Http\Controllers\Controller;
use App\Models\RecConfession;
use Illuminate\Http\Request;

class HistoryConfessionResponseController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected ResponseService $responseService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(ResponseService $responseService)
    {
        parent::__construct();
        $this->responseService = $responseService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->responseService->index($this->userData, $this->userRole);
    }

    public function create(RecConfession $confession)
    {
        return $this->responseService->create($this->userData, $this->userRole, $confession);
    }

    public function store(Request $request, RecConfession $confession)
    {
        return $this->responseService->store($request, $this->userData, $this->userRole, $confession);
    }

    public function edit($idConfessionResponse)
    {
        return $this->responseService->edit($this->userData, $this->userRole, $idConfessionResponse);
    }

    public function update(Request $request, $idConfessionResponse)
    {
        return $this->responseService->update($request, $this->userData, $this->userRole, $idConfessionResponse);
    }

    public function destroy($idConfessionResponse)
    {
        return $this->responseService->destroy($this->userData, $this->userRole, $idConfessionResponse);
    }


    // ---------------------------------
    // UTILITIES
    public function destroyAttachment($idConfessionResponse)
    {
        return $this->responseService->destroyAttachment($this->userData, $this->userRole, $idConfessionResponse);
    }
}
