@extends('layouts.app')
@section('title', 'สร้างใบเสนอราคา')

@section('content')
  <div class="container py-4">

    <h4>📄 ใบเสนอราคา</h4>

    <form method="POST" action="{{ route('quotation.store') }}">
      @csrf

      <input name="quotation_no" class="form-control mb-2" placeholder="เลขที่">

      <input type="date" name="quote_date" class="form-control mb-2">
      <input type="date" name="valid_until" class="form-control mb-3">

      <select name="customer_id" class="form-control mb-3">
        <option value="">-- ลูกค้า --</option>
        @foreach ($customers as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>

      <table class="table" id="itemTable">
        <thead>
          <tr>
            <th>รายการ</th>
            <th>จำนวน</th>
            <th>ราคา</th>
            <th>รวม</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <button type="button" onclick="addRow()" class="btn btn-secondary">+ เพิ่ม</button>

      <h5 class="mt-3">รวม: <span id="grandTotal">0</span></h5>

      <button class="btn btn-primary mt-3">บันทึก</button>

    </form>
  </div>
@endsection
