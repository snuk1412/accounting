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
                <p>ชื่อผู้ประกอบการ: <strong>บริษัท ตัวอย่างง จำกัด </strong></p>
                <p>ชื่อสถานประกอบการ: <strong>----</strong></p>
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
        // จัดเตรียมข้อมูลลูกค้า
        $customer = $invoice->customer;

        $subtotal = $invoice->total;
        // $rate = $invoice->created_at->year >= 2026 ? 0.1 : 0.07;
        $rate = 0.07;

        $tax = $subtotal * $rate;
        $grandTotal = $subtotal + $tax;

        $sumTotal += $subtotal;
        $sumTax += $tax;
        $sumGrandTotal += $grandTotal;
    @endphp
    <tr>
        <td align="center">{{ $index + 1 }}</td>
        <td align="center">{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</td>
        <td>{{ $invoice->invoice_number ?? '-' }}</td>

        {{-- ดึงชื่อลูกค้า --}}
        {{-- <td>{{ $customer->name ?? 'ลูกค้าทั่วไป' }}</td> --}}
<td>{{ $invoice->invoice_no ?? 'ไม่่ระบุ' }}</td>
        {{-- ตรวจสอบสถานประกอบการ (สำนักงานใหญ่/สาขา) --}}
        <td align="center">{{ ($customer->is_main_branch ?? true) ? 'X' : '' }}</td>
        <td align="center">{{ (!($customer->is_main_branch ?? true)) ? ($customer->branch_code ?? '00001') : '' }}</td>

        {{-- เลขประจำตัวผู้เสียภาษี --}}
        <td align="center">{{ $customer->tax_number ?? '-' }}</td>

        <td align="right">{{ number_format($subtotal, 2) }}</td>
        <td align="right">{{ number_format($tax, 2) }}</td>
        <td align="right">{{ number_format($grandTotal, 2) }}</td>
    </tr>
@empty
    <tr>
        <td colspan="10" align="center">ไม่พบข้อมูลการขายในเดือนนี้</td>
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
