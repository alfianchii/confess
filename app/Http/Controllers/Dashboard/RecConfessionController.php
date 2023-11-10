<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\RecConfession;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\ConfessionService;

class RecConfessionController extends Controller
{
    // ---------------------------------
    // PROPERTIES
    protected ConfessionService $confessionService;


    // ---------------------------------
    // MAGIC FUNCTIONS
    public function __construct(ConfessionService $confessionService)
    {
        parent::__construct();
        $this->confessionService = $confessionService;
    }


    // ---------------------------------
    // CORES
    public function index()
    {
        return $this->confessionService->index($this->userData, $this->userRole);
    }

    public function create()
    {
        return $this->confessionService->create($this->userRole);
    }

    public function store(Request $request)
    {
        return $this->confessionService->store($request, $this->userData, $this->userRole);
    }

    public function edit(RecConfession $confession)
    {
        return $this->confessionService->edit($this->userData, $this->userRole, $confession);
    }

    public function update(Request $request, RecConfession $confession)
    {
        return $this->confessionService->update($request, $this->userData, $this->userRole, $confession);
    }

    public function destroy(string $slug)
    {
        return $this->confessionService->destroy($this->userData, $this->userRole, $slug);
    }

    public function export(Request $request)
    {
        return $this->confessionService->export($request, $this->userData, $this->userRole);
    }

    // ---------------------------------
    // UTILITIES
    public function checkSlug(Request $request)
    {
        return $this->confessionService->checkSlug($request, $this->userRole);
    }

    public function destroyImage(string $slug)
    {
        return $this->confessionService->destroyImage($this->userData, $this->userRole, $slug);
    }

    public function pick(RecConfession $confession)
    {
        return $this->confessionService->pick($this->userData, $this->userRole, $confession);
    }

    public function release(RecConfession $confession)
    {
        return $this->confessionService->release($this->userData, $this->userRole, $confession);
    }

    public function close(RecConfession $confession)
    {
        return $this->confessionService->close($this->userData, $this->userRole, $confession);
    }
}
