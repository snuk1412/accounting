@extends('layouts.app')

@section('title','แก้ไขลูกค้า')

@section('content')

<div class="card p-4">

<h4 class="mb-3">
แก้ไขลูกค้า
</h4>

<form action="{{ route('customers.update',$customer->id) }}" method="POST">

@csrf
@method('PUT')

{{-- บริษัท --}}
<div class="form-group mb-3">

<label class="fw-bold">
บริษัท
</label>

<select name="companies_id"
        class="form-control @error('companies_id') is-invalid @enderror">

<option value="">
-- เลือกบริษัท --
</option>

@foreach ($companies as $company)

<option value="{{ $company->id }}"
{{ old('companies_id',$customer->companies_id) == $company->id ? 'selected' : '' }}>

{{ $company->name }}

</option>

@endforeach

</select>

@error('companies_id')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


{{-- เลขบัตร --}}
<div class="form-group mb-3">

<label class="fw-bold">
เลขบัตรประชาชน/เลขที่ผู้เสียภาษี
</label>

<input
type="text"
name="customer_code"
maxlength="13"
pattern="[0-9]{13}"
class="form-control @error('customer_code') is-invalid @enderror"
value="{{ old('customer_code',$customer->customer_code) }}"
placeholder="กรอกเลขบัตร 13 หลัก"
oninput="this.value=this.value.replace(/[^0-9]/g,'')"
>

@error('customer_code')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


{{-- ชื่อลูกค้า --}}
<div class="form-group mb-3">

<label class="fw-bold">
ชื่อลูกค้า
</label>

<input
type="text"
name="name"
class="form-control @error('name') is-invalid @enderror"
value="{{ old('name',$customer->name) }}"
required>

@error('name')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


{{-- โทรศัพท์ --}}
<div class="form-group mb-3">

<label>
โทรศัพท์
</label>

<input
type="text"
name="phone"
class="form-control @error('phone') is-invalid @enderror"
value="{{ old('phone',$customer->phone) }}">

@error('phone')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


{{-- Email --}}
<div class="form-group mb-3">

<label>
Email
</label>

<input
type="email"
name="email"
class="form-control @error('email') is-invalid @enderror"
value="{{ old('email',$customer->email) }}">

@error('email')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


{{-- ที่อยู่ --}}
<div class="form-group mb-3">

<label class="fw-bold">
ที่อยู่
</label>

<textarea
name="address"
rows="3"
class="form-control @error('address') is-invalid @enderror"
placeholder="กรอกที่อยู่ลูกค้า">{{ old('address',$customer->address) }}</textarea>

@error('address')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror

</div>


<button class="btn btn-warning">
อัปเดต
</button>

<a href="{{ route('customers.index') }}"
class="btn btn-secondary">
ยกเลิก
</a>

</form>

</div>

@endsection
