<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ใบเสนอราคา</title>

<style>
@page {
  size: A4;
  margin: 20px;
}

/* ===== FONT THAI ===== */
/* ===== FONT THAI THSarabunNew ===== */
@font-face {
  font-family: 'THSarabunNew';
  src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}") format("truetype");
  font-weight: 400;
  font-style: normal;
}

@font-face {
  font-family: 'THSarabunNew';
  src: url("{{ storage_path('fonts/THSarabunNew-Bold.ttf') }}") format("truetype");
  font-weight: 700;
  font-style: normal;
}

@font-face {
  font-family: 'THSarabunNew';
  src: url("{{ storage_path('fonts/THSarabunNew-Italic.ttf') }}") format("truetype");
  font-weight: 400;
  font-style: italic;
}

@font-face {
  font-family: 'THSarabunNew';
  src: url("{{ storage_path('fonts/THSarabunNew-BoldItalic.ttf') }}") format("truetype");
  font-weight: 700;
  font-style: italic;
}

/* ===== BODY DEFAULT ===== */
body {
  font-family: 'THSarabunNew', sans-serif;
  font-size: 20px; /* ปรับตามความเหมาะสม 18-20px */
  line-height: 1.5;
  color: #000;
  margin: 0;
  padding: 0;
}

/* ลบ font-family ในจุดย่อยอื่นๆ ออกเพื่อให้ใช้ค่าจาก body ทั้งหมด */
table, th, td, div {
  font-family: 'THSarabunNew', sans-serif;
}

/* ===== LAYOUT ===== */
.container { width: 100%; }
table { width: 100%; border-collapse: collapse; }

/* ===== HEADER ===== */
.header-table td { vertical-align: top; }
.company-name { font-size: 20px; font-weight: 700; }
.doc-title { text-align: right; }
.doc-title h2 { margin: 0; }

/* ===== CUSTOMER ===== */
.customer { margin-top: 10px; font-weight: 400; }

/* ===== ITEM TABLE ===== */
.item-table th {
  background: #f0f0f0;
  text-align: center;
  font-weight: 700;
}
.item-table th, .item-table td {
  border: 1px solid #000;
  padding: 6px;
}
.text-right { text-align: right; }

/* ===== TOTAL ===== */
.total-table td { padding: 5px; }
.total-box { margin-top: 10px; }
.grand-total td { border-top: 2px solid #000; font-weight: 700; font-size: 18px; }

/* ===== SIGNATURE ===== */
.signature-table { margin-top: 60px; }
.signature-line { margin-top: 50px; border-top: 1px solid #000; text-align: center; }
</style>
</head>

<body>
<div class="container">

  <!-- HEADER -->
  <table class="header-table">
    <tr>
      <td width="60%">
        <div class="company-name">บริษัท ของคุณ จำกัด</div>
        <div>ที่อยู่บริษัท / เบอร์โทร</div>
      </td>
      <td width="40%" class="doc-title">
        <h2>ใบเสนอราคา</h2>
        เลขที่: {{ $invoice->invoice_no ?? '-' }}<br>
        วันที่: {{ optional($invoice->quote_date)->format('d/m/Y') }}
      </td>
    </tr>
  </table>

  <!-- CUSTOMER -->
  <div class="customer">
    <strong>ชื่อลูกค้า:</strong> {{ $invoice->customer->name ?? '-' }}
  </div>

  <!-- ITEM TABLE -->
  <table class="item-table" style="margin-top:10px;">
    <thead>
      <tr>
        <th>รายการ</th>
        <th width="80">จำนวน</th>
        <th width="120">ราคาต่อหน่วย</th>
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
          <td>{{ $item['description'] ?? '-' }}</td>
          <td class="text-right">{{ number_format($qty) }}</td>
          <td class="text-right">{{ number_format($price, 2) }}</td>
          <td class="text-right">{{ number_format($qty * $price, 2) }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" style="text-align:center;">ไม่มีรายการ</td>
        </tr>
      @endforelse
    </tbody>
  </table>

  <!-- TOTAL -->
  <table class="total-box">
    <tr>
      <td width="60%"></td>
      <td width="40%">
        <table class="total-table">
          <tr>
            <td>รวมเป็นเงิน</td>
            <td class="text-right">{{ number_format($invoice->total ?? 0, 2) }}</td>
          </tr>
          <tr class="grand-total">
            <td>รวมสุทธิ</td>
            <td class="text-right">{{ number_format($invoice->total ?? 0, 2) }} บาท</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <!-- SIGNATURE -->
  <table class="signature-table">
    <tr>
      <td width="50%" align="center"><div class="signature-line">ผู้จัดทำ</div></td>
      <td width="50%" align="center"><div class="signature-line">ผู้อนุมัติ</div></td>
    </tr>
  </table>

</div>
</body>
</html>
