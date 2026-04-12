@extends('layouts.app')
@section('title', 'แก้ไขลูกค้า')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">✏️ แก้ไขลูกค้า</h4>

      <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      {{-- แสดง error ทั้งหมด --}}
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('customers.update', $row->id) }}">
        @csrf
        @method('PUT')

        {{-- เลขบัตร --}}
        <div class="mb-3">
          <label class="fw-bold">เลขบัตรประชาชน/เลขที่ผู้เสียภาษี</label>
          <input type="text" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" value="{{ old('customer_code', $row->customer_code) }}" placeholder="กรอกเลขบัตร 13 หลัก">

          @error('customer_code')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- ชื่อ --}}
        <div class="mb-3">
          <label class="fw-bold">ชื่อลูกค้า</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $row->name) }}" placeholder="เช่น สมชาย ใจดี">

          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- บริษัท --}}
        <div class="mb-3">
          <label class="fw-bold">บริษัท</label>
          <select name="companies_id" class="form-control @error('companies_id') is-invalid @enderror">
            <option value="" selected disabled>-- เลือกบริษัท --</option>
            @foreach ($companies as $company)
              <option value="{{ $company->id }}" {{ $row->companies_id == $company->id ? 'selected' : '' }}>
                {{ $company->name }}
              </option>
            @endforeach
          </select>

          @error('companies_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- โทรศัพท์ --}}
        <div class="mb-3">
          <label class="fw-bold">โทรศัพท์</label>
          <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $row->phone) }}" placeholder="08xxxxxxxx">

          @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label class="fw-bold">Email</label>
          <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $row->email) }}" placeholder="example@email.com">

          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- ที่อยู่ --}}
        <div class="mb-4">
          <label class="fw-bold">ที่อยู่</label>
          <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="กรอกที่อยู่">{{ old('address', $row->address) }}</textarea>

          @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-primary fw-bold">
          💾 อัพเดทข้อมูล
        </button>

      </form>

    </div>
  </div>

@endsection
