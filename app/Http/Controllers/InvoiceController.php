<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuotationExport;
use Illuminate\Validation\Rules\In;
use App\Models\Payment;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('customer');

        // ฟิลเตอร์ชื่อลูกค้า
        if ($request->filled('customer')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%');
            });
        }

        // ฟิลเตอร์ตาม status (0=ค้างชำระ, 1=ชำระครบ, 2=เกินกำหนด)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ฟิลเตอร์ตามช่วงวันที่ครบกำหนด
        if ($request->filled('date_from')) {
            $query->where('due_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('due_date', '<=', $request->date_to);
        }

        $data = $query->orderBy('due_date', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('invoice.index', compact('data'));
    }

    public function create()
    {
        // ดึง Invoice ล่าสุด
        $lastInvoice = \App\Models\Invoice::latest('id')->first();

        if ($lastInvoice) {
            // แยกตัวเลขจาก INV0000001
            $number = (int) str_replace('INV', '', $lastInvoice->invoice_no);
            $newNumber = $number + 1;
        } else {
            $newNumber = 1;
        }

        // ฟอร์แมตรูปแบบ INV + 7 หลัก
        $invoice_no = 'INV' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);

        // ดึงลูกค้าสำหรับ select
        $customers = \App\Models\Customer::all();

        return view('invoice.create', compact('invoice_no', 'customers'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|unique:invoices,invoice_no',
            'customer_id' => 'required|exists:customers,id',
            'due_date' => 'required',
            'items' => 'required|array'
        ]);

        $due_date = Carbon::createFromFormat('d/m/Y', $request->due_date)->format('Y-m-d');

        $items = [];
        $total = 0;

        foreach ($request->items as $item) {

            $qty = (int) ($item['qty'] ?? 0);
            $price = (float) str_replace(',', '', $item['price'] ?? 0);

            $line_total = $qty * $price;

            $items[] = [
                'description' => $item['description'] ?? '',
                'qty' => $qty,
                'price' => $price,
                'total' => $line_total
            ];

            $total += $line_total;
        }

        Invoice::create([
            'invoice_no' => $request->invoice_no,
            'customer_id' => $request->customer_id,
            'total' => $total,
            'paid' => 0,
            'due_date' => $due_date,
            'status' => 0,
            'items' => $items
        ]);

        return redirect()->route('invoice.index')
            ->with('success', 'สร้างใบแจ้งหนี้สำเร็จ');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::latest()->get();

        return view('invoice.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_no' => 'required|unique:invoices,invoice_no,' . $id,
            'customer_id' => 'required|exists:customers,id',
            'due_date' => 'required',
            'items' => 'required|array'
        ]);

        $due_date = Carbon::createFromFormat('d/m/Y', $request->due_date)->format('Y-m-d');

        $items = [];
        $total = 0;

        foreach ($request->items as $item) {

            $qty = (int) ($item['qty'] ?? 0);
            $price = (float) str_replace(',', '', $item['price'] ?? 0);

            $line_total = $qty * $price;

            $items[] = [
                'description' => $item['description'] ?? '',
                'qty' => $qty,
                'price' => $price,
                'total' => $line_total
            ];

            $total += $line_total;
        }

        $status = $request->status ?? 0;

        $paid = str_replace(',', '', $request->paid ?? 0);

        if ($status == 1 && $paid == 0) {
            $paid = $total;
        }

        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'invoice_no' => $request->invoice_no,
            'customer_id' => $request->customer_id,
            'due_date' => $due_date,
            'total' => $total,
            'paid' => $paid,
            'status' => $status,
            'items' => $items
        ]);

        return redirect()->route('invoice.index')
            ->with('success', 'อัปเดตใบแจ้งหนี้สำเร็จ');
    }
    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return back()->with('success', 'ลบข้อมูลสำเร็จ');
    }

    // app/Http/Controllers/InvoiceController.php

    public function storePayment(Request $request, Invoice $invoice)
    {
        // รวมยอดจ่ายปัจจุบัน
        $totalPaid = $invoice->payments()->sum('amount');

        // กันจ่ายเกิน
        $remaining = $invoice->total - $totalPaid;
        if ($request->amount > $remaining) {
            return back()->with('error', 'จำนวนเงินเกินยอดคงเหลือ');
        }

        // Validate
        $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ]);

        // สร้าง payment
        $invoice->payments()->create([
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        // อัปเดตยอด invoice
        $invoice->paid = $invoice->payments()->sum('amount');
        $invoice->balance = $invoice->total - $invoice->paid;
        $invoice->status = $invoice->balance <= 0 ? 1 : ($invoice->due_date < now() ? 2 : 0);
        $invoice->save();

        return back()->with('success', 'เพิ่มประวัติการชำระเงินเรียบร้อยแล้ว');
    }

    public function deletePayment(Payment $payment)
    {
        $invoice = $payment->invoice;
        $payment->delete();

        // อัปเดตยอด invoice
        $invoice->paid = $invoice->payments()->sum('amount');
        $invoice->balance = $invoice->total - $invoice->paid;
        $invoice->status = $invoice->balance <= 0 ? 1 : ($invoice->due_date < now() ? 2 : 0);
        $invoice->save();

        return back()->with('success', 'ลบประวัติการชำระเงินเรียบร้อยแล้ว');
    }

    public function pdf($id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);

        $pdf = Pdf::loadView('invoice.pdf.index', compact('invoice'));

        return $pdf->download('invoice_' . $invoice->invoice_no . '.pdf');
    }

    public function excel($id)
    {
        $quotation = Quotation::findOrFail($id);
        return Excel::download(new QuotationExport($quotation), 'quotation.xlsx');
    }
}
