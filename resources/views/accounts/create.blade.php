
@extends('layouts.app')

@section('title', 'แก้ไขผังบัญชี')
@section('content')

  <style>
    .glass-card {
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.75);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: .3s;
    }

    body.dark-mode .glass-card {
      background: rgba(30, 41, 59, 0.7);
      color: #f1f5f9;
    }

    .btn-modern {
      border-radius: 50px;
      padding: 8px 28px;
      border: none;
      transition: .3s;
    }

    .btn-save {
      background: linear-gradient(90deg, #16a34a, #22c55e);
      color: #fff;
    }

    .btn-cancel {
      background: #64748b;
      color: #fff;
    }
  </style>
<div class="container py-4">

<h4 class="fw-bold mb-4">➕ เพิ่มผังบัญชี</h4>

<div class="glass-card p-4">

<form action="{{ route('accounts.store') }}" method="POST" onsubmit="disableBtn()">
@csrf

<div class="mb-3">
<label>รหัสบัญชี</label>

<input type="text"
name="code"
id="code"
class="form-control @error('code') is-invalid @enderror"
value="{{ old('code') }}"
required>

@error('code')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>


<div class="mb-3">
<label>ชื่อบัญชี</label>

<input type="text"
name="name"
class="form-control @error('name') is-invalid @enderror"
value="{{ old('name') }}"
required>

@error('name')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>


<div class="mb-3">
<label>ประเภทบัญชี</label>

<select name="type"
class="form-control @error('type') is-invalid @enderror"
required>

<option value="">-- เลือกประเภทบัญชี --</option>

<option value="asset" {{ old('type') == 'asset' ? 'selected' : '' }}>
สินทรัพย์
</option>

<option value="liability" {{ old('type') == 'liability' ? 'selected' : '' }}>
หนี้สิน
</option>

<option value="equity" {{ old('type') == 'equity' ? 'selected' : '' }}>
ทุน
</option>

<option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>
รายได้
</option>

<option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>
ค่าใช้จ่าย
</option>

</select>

@error('type')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>


<div class="mt-4">

<button id="submitBtn" class="btn btn-modern btn-save">
<i class="fas fa-save"></i> บันทึก
</button>

<a href="{{ route('accounts.index') }}" class="btn btn-modern btn-cancel">
ยกเลิก
</a>

</div>

</form>

</div>
</div>

@endsection
