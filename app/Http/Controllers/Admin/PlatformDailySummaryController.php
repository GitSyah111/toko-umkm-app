<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformDailySummary;
use App\Http\Requests\StorePlatformDailySummaryRequest;
use App\Http\Requests\UpdatePlatformDailySummaryRequest;
use App\Services\PlatformDailySummaryService;

class PlatformDailySummaryController extends Controller
{
    protected $platformSummaryService;

    public function __construct(PlatformDailySummaryService $platformSummaryService)
    {
        $this->platformSummaryService = $platformSummaryService;
    }

    public function index()
    {
        $data = PlatformDailySummary::orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.platform_daily_summary.index', compact('data'));
    }

    public function create()
    {
        return view('admin.platform_daily_summary.create');
    }

    public function store(StorePlatformDailySummaryRequest $request)
    {
        $this->platformSummaryService->store($request->validated());
        return redirect()->route('admin.platform-summary.index')->with('success', 'Summary created successfully.');
    }

    public function show(PlatformDailySummary $platform_summary)
    {
        return view('admin.platform_daily_summary.show', ['data' => $platform_summary]);
    }

    public function edit(PlatformDailySummary $platform_summary)
    {
        return view('admin.platform_daily_summary.edit', ['data' => $platform_summary]);
    }

    public function update(UpdatePlatformDailySummaryRequest $request, PlatformDailySummary $platform_summary)
    {
        $this->platformSummaryService->update($platform_summary, $request->validated());
        return redirect()->route('admin.platform-summary.index')->with('success', 'Summary updated successfully.');
    }

    public function destroy(PlatformDailySummary $platform_summary)
    {
        $this->platformSummaryService->delete($platform_summary);
        return redirect()->route('admin.platform-summary.index')->with('success', 'Summary deleted successfully.');
    }
}
