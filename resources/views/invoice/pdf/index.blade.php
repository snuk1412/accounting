<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<style>
/* ตั้งค่าหน้ากระดาษ */
@page {
    size: A4;
    margin: 1cm; /* ปรับ Margin ให้แคบลงเพื่อประหยัดพื้นที่ */
}

@font-face {
  font-family: 'Sarabun';
  src: url("{{ storage_path('fonts/Sarabun-Regular.ttf') }}") format("truetype");
}

/* CSS หลักเพื่อคุม Layout และแก้สระลอย */
body {
    font-family: 'Sarabun', sans-serif;
    font-size: 13px; /* ลดขนาดลงเล็กน้อย */
    line-height: 1.2; /* ปรับ line-height เพื่อลดการห่างของสระ */
    margin: 0;
    padding: 0;
    color: #333;
    -webkit-print-color-adjust: exact;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* คุมความกว้างตารางให้คงที่ */
    word-wrap: break-word;
}

/* Header */
.header-table td { vertical-align: top; }
.logo-text { font-size: 28px; font-weight: bold; color: #14a37b; }
.company-info { text-align: right; font-size: 11px; }

/* Quote Title Box */
.quote-box { width: 100%; border: 1px solid #000; margin-top: 5px; }
.quote-title { background-color: #43c6ac; color: white; text-align: center; padding: 5px; font-weight: bold; }
.quote-no { text-align: center; padding: 5px; font-size: 14px; }

/* Info Section */
.info-section { border: 1px solid #000; margin-top: 10px; }
.info-section td { border: 1px solid #000; padding: 4px 8px; vertical-align: top; font-size: 12px; }

/* Item Table */
.item-table { margin-top: 10px; min-height: 350px; } /* ลด min-height ลง */
.item-table th { background-color: #43c6ac; color: white; border: 1px solid #000; padding: 6px; font-size: 12px; }
.item-table td { border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px; height: 22px; }
.item-table tr.last-row td { border-bottom: 1px solid #000; }

/* Summary Area */
.summary-container { margin-top: 0; border: 1px solid #000; border-top: none; }
.amount-thai { padding: 10px; background: #f2f2f2; font-weight: bold; vertical-align: middle; }
.calc-table td { border: 1px solid #000; padding: 4px 8px; text-align: right; }
.bg-green { background-color: #43c6ac; color: white; font-weight: bold; }

/* Footer/Signatures */
.signature-table { margin-top: 15px; }
.signature-table td { border: 1px solid #000; height: 80px; text-align: center; vertical-align: bottom; padding-bottom: 5px; font-size: 11px; }

.text-right { text-align: right; }
.text-center { text-align: center; }
.bold { font-weight: bold; }
</style>
</head>
<body>

<table class="header-table">
  <tr>
    <td width="55%">
        <div class="logo-text">SME MOVE</div>
    </td>
    <td class="company-info">
      <div class="bold">Gameolo</div>
      111 อาคารเอไอเอ แคปปิตอล เซ็นเตอร์ ถนนรัชดาภิเษก แขวงดินแดง เขตดินแดง กรุงเทพฯ 10400<br>
      เลขประจำตัวผู้เสียภาษี 0-0164-60313-31-1 (สำนักงานใหญ่)
    </td>
  </tr>
</table>

<table style="margin-top: 10px;">
    <tr>
        <td width="65%" style="padding-right: 10px;">
            <table class="info-section">
                <tr>
                    <td width="60%"><span class="bold">ชื่อลูกค้า:</span> {{ $invoice->customer->name ?? 'บจก. A จำกัด' }}</td>
                    <td><span class="bold">วันที่:</span> {{ optional($invoice->quote_date)->format('d/m/Y') ?? '08/01/2562' }}</td>
                </tr>
                <tr>
                    <td><span class="bold">เลขที่ผู้เสียภาษี:</span> 0190901999999</td>
                    <td><span class="bold">การชำระเงิน:</span> 60 วัน</td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 35px;"><span class="bold">ที่อยู่:</span> 9/99 หมู่ 9 ถนนเลขที่ 9</td>
                </tr>
            </table>
        </td>
        <td width="35%">
            <div class="quote-box">
                <div class="quote-title">Quotation / ใบเสนอราคา</div>
                <div class="quote-no bold">{{ $invoice->invoice_no ?? 'QT-20190009' }}</div>
            </div>
        </td>
    </tr>
</table>

<table class="item-table">
  <thead>
    <tr>
      <th width="8%">เลขที่</th>
      <th width="42%">รายการ</th>
      <th width="10%">จำนวน</th>
      <th width="15%">ราคา/หน่วย</th>
      <th width="10%">ส่วนลด</th>
      <th width="15%">จำนวนเงิน</th>
    </tr>
  </thead>
  <tbody>
    @php $rowCount = 0; @endphp
    @foreach ($invoice->items ?? [['description' => 'Acer Predator', 'qty' => 1, 'price' => 35000]] as $index => $item)
    <tr>
      <td class="text-center">{{ $index + 1 }}</td>
      <td>{{ $item['description'] }}</td>
      <td class="text-center">{{ number_format($item['qty'] ?? 1) }}</td>
      <td class="text-right">{{ number_format($item['price'] ?? 0, 2) }}</td>
      <td class="text-right">0.00</td>
      <td class="text-right">{{ number_format(($item['qty'] ?? 1) * ($item['price'] ?? 0), 2) }}</td>
    </tr>
    @php $rowCount++; @endphp
    @endforeach

    @for ($i = $rowCount; $i < 12; $i++)
    <tr>
      <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    @endfor
    <tr class="last-row">
      <td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
  </tbody>
</table>

{{-- vat 7% --}}
@php
    $subtotal = 0;

    foreach ($invoice->items ?? [] as $item) {
        $qty = $item['qty'] ?? 0;
        $price = $item['price'] ?? 0;
        $subtotal += $qty * $price;
    }

    $vat = $subtotal * 0.07;
    $grandTotal = $subtotal + $vat;

    if (!function_exists('baht_text')) {
    function baht_text($number)
    {
        return number_format($number, 2) . ' บาท';
    }
}
@endphp
{{-- ............ vat 7% --}}

<table class="summary-container">
    <tr>
        <td width="55%" class="amount-thai text-center">
            ( {{ baht_text($grandTotal) }} )
        </td>
        <td width="45%">
            <table class="calc-table">
                <tr>
                    <td>รวมเป็นเงิน (Subtotal)</td>
                    <td width="120">{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>ภาษีมูลค่าเพิ่ม 7%</td>
                    <td>{{ number_format($vat, 2) }}</td>
                </tr>
                <tr class="bg-green">
                    <td>รวมสุทธิ (Total)</td>
                    <td>{{ number_format($grandTotal, 2) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="signature-table">
  <tr>
    <td width="33%">
      <div>......................................................</div>
      <div>ผู้อนุมัติสั่งซื้อ / Customer</div>
    </td>
    <td width="34%" style="border: none;">
       <div style="color: #43c6ac; font-weight: bold; font-size: 20px; border: 2px dashed #43c6ac; display: inline-block; padding: 10px; margin-bottom: 10px;">
         SME MOVE
       </div>
    </td>
    <td width="33%">
      <div>......................................................</div>
      <div>ผู้อำนาจลงนาม / Authorized</div>
      <div style="font-size: 10px; margin-top: 3px;">วันที่ 08/01/2562</div>
    </td>
  </tr>
</table>

</body>
</html>
