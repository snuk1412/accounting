<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">

<style>

/* ===== PAGE ===== */
@page {
    size: A4;
    margin: 0.7cm;
}

/* ===== FONT ===== */
@font-face {
    font-family: 'Sarabun';
    src: url("{{ storage_path('fonts/Sarabun-Regular.ttf') }}") format("truetype");
}
@font-face {
    font-family: 'Sarabun';
    src: url("{{ storage_path('fonts/Sarabun-Bold.ttf') }}") format("truetype");
    font-weight: bold;
}

/* ===== GLOBAL ===== */
body {
    font-family: 'Sarabun';
    font-size: 13px;
    line-height: 1.35;
    margin: 0;

    transform: scale(0.97);        /* 🔥 ดีกว่า zoom */
    transform-origin: top left;
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
}

tr {
    page-break-inside: avoid;
}

td, th {
    padding: 4px 6px;         /* 🔥 ลด */
    vertical-align: top;
}

/* ===== HEADER ===== */
.logo-text {
    font-size: 22px;          /* 🔥 ลด */
    font-weight: bold;
    color: #14a37b;
}

.company-info {
    text-align: right;
    font-size: 11px;
}

/* ===== QUOTE ===== */
.quote-box { border: 1px solid #000; }

.quote-title {
    background: #43c6ac;
    color: #fff;
    text-align: center;
    padding: 5px;
    font-weight: bold;
}

.quote-no {
    text-align: center;
    padding: 5px;
    font-weight: bold;
}

/* ===== INFO ===== */
.info-section td {
    border: 1px solid #000;
    font-size: 12px;
}

/* ===== ITEM ===== */
.item-table { margin-top: 6px; }

.item-table th {
    background: #43c6ac;
    color: #fff;
    border: 1px solid #000;
}

.item-table td {
    border-left: 1px solid #000;
    border-right: 1px solid #000;
}

.item-table tr:last-child td {
    border-bottom: 1px solid #000;
}

/* ===== SUMMARY ===== */
.summary-container {
    border: 1px solid #000;
    border-top: none;
}

.amount-thai {
    background: #f2f2f2;
    padding: 6px;
    text-align: center;
    font-weight: bold;
}

.calc-table td {
    border-bottom: 1px solid #000;
}

.calc-table tr:last-child td {
    border-bottom: none;
}

.bg-green {
    background: #43c6ac;
    color: #fff;
    font-weight: bold;
}

/* ===== SIGN ===== */
.signature-table {
    margin-top: 10px; /* 🔥 ไม่ใช้ absolute แล้ว */
}

.signature-table td {
    border: 1px solid #000;
    height: 70px; /* 🔥 ลด */
    text-align: center;
    vertical-align: bottom;
}

/* ===== UTIL ===== */
.text-right { text-align: right; }
.text-center { text-align: center; }

</style>
</head>

<body>

@php
$items = $invoice->items ?? [['description' => 'สินค้าตัวอย่าง Acer Predator', 'qty' => 1, 'price' => 35000]];

$subtotal = 0;
foreach ($items as $item) {
    $subtotal += ($item['qty'] ?? 0) * ($item['price'] ?? 0);
}

$vat = $subtotal * 0.07;
$grandTotal = $subtotal + $vat;

$maxRows = 10; // 🔥 ปรับใหม่
$rowCount = count($items);

function baht_text($number) {
    return number_format($number, 2) . ' บาท';
}
@endphp

<!-- HEADER -->
<table>
<tr>
<td width="50%">
    <div class="logo-text">SME MOVE</div>
</td>
<td class="company-info">
    <b>Gameolo</b><br>
    กรุงเทพฯ 10400
</td>
</tr>
</table>

<!-- INFO -->
<table style="margin-top:6px;">
<tr>
<td width="65%">
<table class="info-section">
<tr>
<td>ลูกค้า: {{ $invoice->customer->name ?? '-' }}</td>
<td>วันที่: {{ date('d/m/Y') }}</td>
</tr>
<tr>
<td>เลขผู้เสียภาษี: {{ $invoice->customer->tax_number ?? '-' }}</td>
<td>เครดิต: 60 วัน</td>
</tr>
<tr>
<td colspan="2" style="height:30px;">ที่อยู่: {{ $invoice->customer->address ?? '-' }}</td>
</tr>
</table>
</td>

<td width="35%">
<div class="quote-box">
<div class="quote-title">Quotation</div>
<div class="quote-no">{{ $invoice->invoice_no ?? 'QT-0001' }}</div>
</div>
</td>
</tr>
</table>

<!-- ITEM -->
<table class="item-table">
<thead>
<tr>
<th width="8%">#</th>
<th width="42%">รายการ</th>
<th width="10%">จำนวน</th>
<th width="15%">ราคา</th>
<th width="10%">ส่วนลด</th>
<th width="15%">รวม</th>
</tr>
</thead>

<tbody>

@foreach ($items as $i => $item)
<tr>
<td class="text-center">{{ $i+1 }}</td>
<td>{{ $item['description'] }}</td>
<td class="text-center">{{ $item['qty'] }}</td>
<td class="text-right">{{ number_format($item['price'],2) }}</td>
<td class="text-right">0.00</td>
<td class="text-right">{{ number_format($item['qty'] * $item['price'],2) }}</td>
</tr>
@endforeach

@for ($i = $rowCount; $i < $maxRows; $i++)
<tr>
<td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td>
</tr>
@endfor

</tbody>
</table>

<!-- SUMMARY -->
<table class="summary-container">
<tr>
<td width="55%" class="amount-thai">
({{ baht_text($grandTotal) }})
</td>

<td width="45%">
<table class="calc-table">
<tr><td>รวม</td><td class="text-right">{{ number_format($subtotal,2) }}</td></tr>
<tr><td>VAT 7%</td><td class="text-right">{{ number_format($vat,2) }}</td></tr>
<tr class="bg-green"><td>สุทธิ</td><td class="text-right">{{ number_format($grandTotal,2) }}</td></tr>
</table>
</td>
</tr>
</table>

<!-- SIGN -->
<table class="signature-table">
<tr>
<td>ผู้สั่งซื้อ</td>
<td style="border:none;">SME MOVE</td>
<td>ผู้อนุมัติ</td>
</tr>
</table>

</body>
</html>
