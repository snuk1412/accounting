<?php
use Carbon\Carbon;
use App\Models\CmsHelper as Cms;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานภาษีขาย</title>
<link rel="stylesheet" href="{{ public_path('css/invoice/style.css') }}"></head>
<body>
    <div class="report-container">
        <header>
            <h2>รายงานภาษีขาย</h2>
            <div class="header-meta">
                <p>ประจำเดือน: <strong>สิงหาคม</strong> พ.ศ. <strong>2567</strong></p>
                <p>ชื่อผู้ประกอบการ: <strong>บริษัท ริมโขงคอนกรีต จำกัด</strong></p>
                <p>ชื่อสถานประกอบการ: <strong>บริษัท ริมโขงคอนกรีต จำกัด (สำนักงานใหญ่)</strong></p>
            </div>
        </header>

  @php
    $sumTotal = 0;
    $sumTax = 0;
    $sumGrandTotal = 0;
@endphp

<table>
    <thead>
        <tr>
            <th rowspan="2">ที่</th>
            <th colspan="2">ใบกำกับภาษี</th>
            <th rowspan="2">ชื่อผู้ซื้อสินค้า</th>
            <th colspan="2">สถาน<br>ประกอบการ</th>
            <th rowspan="2">เลขประจำตัว<br>ผู้เสียภาษีอากร</th>
            <th rowspan="2">มูลค่าสินค้า<br>หรือบริการ</th>
            <th rowspan="2">จำนวนเงินภาษี<br>มูลค่าเพิ่ม</th>
            <th rowspan="2">รวม</th>
        </tr>
        <tr>
            <th>ว/ด/ป</th>
            <th>เลขที่</th>
            <th>สนง. ใหญ่</th>
            <th>สาขาที่</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoices as $index => $invoice)
            @php
                // Calculation Logic
                $subtotal = $invoice->total;
                $rate = $invoice->created_at->year >= 2026 ? 0.1 : 0.07;
                $tax = $subtotal * $rate;
                $grandTotal = $subtotal + $tax;

                // Accumulate Totals for Footer
                $sumTotal += $subtotal;
                $sumTax += $tax;
                $sumGrandTotal += $grandTotal;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</td>
                <td>{{ $invoice->invoice_number ?? '-' }}</td> {{-- Changed from tax to invoice number for clarity --}}
                <td>{{ $invoice->customer->name }}</td>
                <td align="center">{{ $invoice->customer->is_main_branch ? 'X' : '' }}</td>
                <td align="center">{{ !$invoice->customer->is_main_branch ? $invoice->customer->branch_code : '' }}</td>
                <td>{{ $invoice->customer->tax_number }}</td>
                <td class="num">{{ number_format($subtotal, 2) }}</td>
                <td class="num">{{ number_format($tax, 2) }}</td>
                <td class="num">{{ number_format($grandTotal, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align: center;">ไม่พบข้อมูล</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="7" style="text-align: right; font-weight: bold;">รวมยอดทั้งสิ้น</td>
            <td class="num"><strong>{{ number_format($sumTotal, 2) }}</strong></td>
            <td class="num"><strong>{{ number_format($sumTax, 2) }}</strong></td>
            <td class="num"><strong>{{ number_format($sumGrandTotal, 2) }}</strong></td>
        </tr>
    </tfoot>
</table>
    </div>
</body>
</html>
