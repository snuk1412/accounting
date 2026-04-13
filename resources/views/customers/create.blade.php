<?php
use Illuminate\Support\Facades\Auth;
?>

@extends('layouts.app')
@section('title', 'เพิ่มลูกค้า')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">➕ เพิ่มลูกค้า</h4>

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

      <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        {{-- เลขบัตร --}}
        <div class="mb-3">
          <label class="fw-bold">เลขบัตรประชาชน/เลขที่ผู้เสียภาษี</label>
          <input type="text" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" value="{{ old('customer_code') }}" placeholder="กรอกเลขบัตร 13 หลัก">

          @error('customer_code')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- ชื่อ --}}
        <div class="mb-3">
          <label class="fw-bold">ชื่อลูกค้า</label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="เช่น สมชาย ใจดี">

          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- บริษัท --}}
        <div class="mb-3 d-none">
          <label class="fw-bold">บริษัท</label>
          <select name="company_name" class="form-control @error('company_name') is-invalid @enderror">
            <option value="" selected disabled>-- เลือกบริษัท --</option>
            @foreach ($companies as $company)
              <option value="{{ $company->id }}" {{ old('company_name', auth::user()->companies_id) == $company->id ? 'selected' : 'disabled' }}>
                {{ $company->name }}
              </option>
            @endforeach
          </select>

          @error('company_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- โทรศัพท์ --}}
        <div class="mb-3">
          <label class="fw-bold">โทรศัพท์</label>
          <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="08xxxxxxxx">

          @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
          <label class="fw-bold">Email</label>
          <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@email.com">

          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- ที่อยู่ --}}
        <div class="mb-4">
          <label class="fw-bold">ที่อยู่ลูกค้า</label>
          <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="กรอกที่อยู่">{{ old('address') }}</textarea>

          @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-primary fw-bold">
          💾 บันทึกข้อมูล
        </button>

      </form>

    </div>
  </div>

@endsection
