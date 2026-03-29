<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuotationExport;

class QuotationController extends Controller
{
    public function index()
    {
        $quotes = Quotation::latest()->get();
        return view('invoice.quotation.index', compact('quotes'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('quotation.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $items = $request->items ?? [];

        $total = collect($items)->sum(function ($item) {
            return ($item['qty'] ?? 0) * ($item['price'] ?? 0);
        });

        Quotation::create([
            'quotation_no' => $request->quotation_no,
            'customer_id' => $request->customer_id,
            'quote_date' => $request->quote_date,
            'valid_until' => $request->valid_until,
            'items' => $items,
            'total' => $total,
        ]);

        return redirect()->route('quotation.index')->with('success', 'บันทึกสำเร็จ');
    }

    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        return view('quotation.show', compact('quotation'));
    }

    public function pdf($id)
    {
        $quotation = Quotation::findOrFail($id);

        $pdf = Pdf::loadView('quotation.pdf', compact('quotation'));
        return $pdf->download('quotation.pdf');
    }

    public function excel($id)
    {
        $quotation = Quotation::findOrFail($id);
        return Excel::download(new QuotationExport($quotation), 'quotation.xlsx');
    }
}
