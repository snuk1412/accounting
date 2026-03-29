<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ใบเสนอราคา</title>

<style>
  body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 14px;
    color: #333;
  }

  h2 {
    margin-bottom: 5px;
  }

  .header {
    margin-bottom: 20px;
  }

  .text-right {
    text-align: right;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
  }

  th, td {
    border: 1px solid #000;
    padding: 6px;
  }

  th {
    background: #f0f0f0;
  }

  .total-box {
    margin-top: 15px;
    text-align: right;
    font-size: 16px;
    font-weight: bold;
  }
</style>
</head>

<body>

<div class="header">
  <h2>ใบเสนอราคา</h2>

  <p>เลขที่: {{ $invoice->invoice_no ?? '-' }}</p>
  <p>วันที่: {{ optional($invoice->quote_date)->format('d/m/Y') }}</p>
  <p>ลูกค้า: {{ $invoice->customer->name ?? '-' }}</p>
</div>

<table>
  <thead>
    <tr>
      <th>รายการ</th>
      <th width="80">จำนวน</th>
      <th width="120">ราคา</th>
      <th width="120">รวม</th>
    </tr>
  </thead>

  <tbody>
    @forelse ($invoice->items ?? [] as $item)
      @php
        $qty = $item['qty'] ?? 0;
        $price = $item['price'] ?? 0;
      @endphp

      <tr>
        <td>{{ $item['description'] ?? '' }}</td>
        <td class="text-right">{{ $qty }}</td>
        <td class="text-right">{{ number_format($price, 2) }}</td>
        <td class="text-right">{{ number_format($qty * $price, 2) }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="4" class="text-center">ไม่มีรายการ</td>
      </tr>
    @endforelse
  </tbody>
</table>

<div class="total-box">
  รวมทั้งหมด: {{ number_format($invoice->total ?? 0, 2) }} บาท
</div>

</body>
</html>
