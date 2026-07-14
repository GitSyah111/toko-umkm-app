<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\TokoDailySummary;
use App\Http\Requests\StoreTokoDailySummaryRequest;
use App\Http\Requests\UpdateTokoDailySummaryRequest;
use App\Services\TokoDailySummaryService;
use Illuminate\Support\Facades\Auth;

class TokoDailySummaryController extends Controller
{
    protected $tokoSummaryService;

    public function __construct(TokoDailySummaryService $tokoSummaryService)
    {
        $this->tokoSummaryService = $tokoSummaryService;
    }

    public function index()
    {
        $toko = Auth::user()->toko;
        if (!$toko) {
            return redirect()->route('dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $data = TokoDailySummary::where('toko_id', $toko->id)->orderBy('tanggal', 'desc')->paginate(10);
        return view('seller.toko_daily_summary.index', compact('data'));
    }

    public function create()
    {
        return view('seller.toko_daily_summary.create');
    }

    public function store(StoreTokoDailySummaryRequest $request)
    {
        $validated = $request->validated();
        $validated['toko_id'] = Auth::user()->toko->id;
        
        $this->tokoSummaryService->store($validated);
        return redirect()->route('seller.toko-summary.index')->with('success', 'Summary created successfully.');
    }

    public function show(TokoDailySummary $toko_summary)
    {
        if ($toko_summary->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }
        return view('seller.toko_daily_summary.show', ['data' => $toko_summary]);
    }

    public function edit(TokoDailySummary $toko_summary)
    {
        if ($toko_summary->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }
        return view('seller.toko_daily_summary.edit', ['data' => $toko_summary]);
    }

    public function update(UpdateTokoDailySummaryRequest $request, TokoDailySummary $toko_summary)
    {
        if ($toko_summary->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }
        $this->tokoSummaryService->update($toko_summary, $request->validated());
        return redirect()->route('seller.toko-summary.index')->with('success', 'Summary updated successfully.');
    }

    public function destroy(TokoDailySummary $toko_summary)
    {
        if ($toko_summary->toko_id !== Auth::user()->toko->id) {
            abort(403);
        }
        $this->tokoSummaryService->delete($toko_summary);
        return redirect()->route('seller.toko-summary.index')->with('success', 'Summary deleted successfully.');
    }
    public function printSalesRecap(\Illuminate\Http\Request $request)
    {
        $toko = Auth::user()->toko;
        if (!$toko) abort(403);
        $data = TokoDailySummary::where('toko_id', $toko->id)->orderBy('tanggal', 'desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.sales_recap', compact('data', 'toko'));
        return $pdf->stream('sales-recap.pdf');
    }

    public function printNetProfit(\Illuminate\Http\Request $request)
    {
        $toko = Auth::user()->toko;
        if (!$toko) abort(403);
        $data = TokoDailySummary::where('toko_id', $toko->id)->orderBy('tanggal', 'desc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.net_profit', compact('data', 'toko'));
        return $pdf->stream('net-profit.pdf');
    }

    public function exportSalesRecapExcel()
    {
        $toko = Auth::user()->toko;
        if (!$toko) abort(403);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SalesRecapExport($toko->id), 'sales-recap.xlsx');
    }

    public function exportNetProfitExcel()
    {
        $toko = Auth::user()->toko;
        if (!$toko) abort(403);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\NetProfitExport($toko->id), 'net-profit.xlsx');
    }
}
