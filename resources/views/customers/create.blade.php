@extends('layouts.app')

@section('content')



<h4 class="mb-4">👤 เพิ่มข้อมูลลูกค้า</h4>

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

<form action="{{ route('customers.store') }}" method="POST">
@csrf


{{-- Card 1 : ข้อมูลผู้ประกอบการ --}}
<div class="card mb-8">

<div class="card-header bg-primary text-white">
ข้อมูลผู้ประกอบการ
</div>

<div class="card-body">

<div class="row">

<div class="row">
<div class="col-md-6 mb-3">
<label class="form-label">เลขประจำตัวผู้เสียภาษี</label>
<input type="text" name="tax_id"
class="form-control @error('tax_id') is-invalid @enderror"
value="{{ old('tax_id') }}">

@error('tax_id')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>

    {{-- ชื่อผู้ประกอบการ --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">ชื่อผู้ประกอบการ</label>
        <input type="text" name="business_name"
        class="form-control @error('business_name') is-invalid @enderror"
        value="{{ old('business_name') }}">

        @error('business_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    {{-- เลขทะเบียนพาณิชย์ --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">เลขทะเบียนพาณิชย์</label>
        <input type="text" name="commercial_registration_no"
        class="form-control @error('commercial_registration_no') is-invalid @enderror"
        value="{{ old('commercial_registration_no') }}">

        @error('commercial_registration_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    {{-- วันที่จดทะเบียน --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">วันที่จดทะเบียน</label>
        <input type="date" name="commercial_registration_date"
        class="form-control @error('commercial_registration_date') is-invalid @enderror"
        value="{{ old('commercial_registration_date') }}">

        @error('commercial_registration_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

</div>


</div>

</div>
</div>


{{-- Card 2 : ข้อมูลติดต่อ --}}
<div class="card mb-4">

<div class="card-header bg-success text-white">
ข้อมูลติดต่อ
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">ชื่อ-นามสกุล</label>
<input type="text" name="fullname"
class="form-control @error('fullname') is-invalid @enderror"
value="{{ old('fullname') }}">

@error('fullname')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>

<div class="col-md-6 mb-3">
<label class="form-label">เบอร์โทร</label>
<input type="text" name="phone"
class="form-control @error('phone') is-invalid @enderror"
value="{{ old('phone') }}">

@error('phone')
<div class="invalid-feedback">
{{ $message }}
</div>
@enderror
</div>

</div>

</div>
</div>


{{-- Card 3 : ที่อยู่ --}}
<div class="card mb-4">

<div class="card-header bg-secondary text-white">
ข้อมูลที่อยู่
</div>

<div class="card-body">

<div class="row">

<div class="col-md-4 mb-3">
<label>อาคาร</label>
<input type="text" name="building" class="form-control" value="{{ old('building') }}">
</div>

<div class="col-md-4 mb-3">
<label>เลขที่ห้อง</label>
<input type="text" name="room_no" class="form-control" value="{{ old('room_no') }}">
</div>

<div class="col-md-4 mb-3">
<label>ชั้น</label>
<input type="text" name="floor" class="form-control" value="{{ old('floor') }}">
</div>

<div class="col-md-6 mb-3">
<label>หมู่บ้าน</label>
<input type="text" name="village" class="form-control" value="{{ old('village') }}">
</div>

<div class="col-md-3 mb-3">
<label>เลขที่</label>
<input type="text" name="house_no" class="form-control" value="{{ old('house_no') }}">
</div>

<div class="col-md-3 mb-3">
<label>หมู่</label>
<input type="text" name="moo" class="form-control" value="{{ old('moo') }}">
</div>

<div class="col-md-4 mb-3">
<label>ซอย</label>
<input type="text" name="soi" class="form-control" value="{{ old('soi') }}">
</div>

<div class="col-md-4 mb-3">
<label>แยก</label>
<input type="text" name="junction" class="form-control" value="{{ old('junction') }}">
</div>

<div class="col-md-4 mb-3">
<label>ถนน</label>
<input type="text" name="road" class="form-control" value="{{ old('road') }}">
</div>

<div class="col-md-4 mb-3">
<label>ตำบล / แขวง</label>
<input type="text" name="subdistrict" class="form-control" value="{{ old('subdistrict') }}">
</div>

<div class="col-md-4 mb-3">
<label>อำเภอ / เขต</label>
<input type="text" name="district" class="form-control" value="{{ old('district') }}">
</div>

<div class="col-md-4 mb-3">
<label>จังหวัด</label>
<input type="text" name="province" class="form-control" value="{{ old('province') }}">
</div>

<div class="col-md-4 mb-3">
<label>รหัสไปรษณีย์</label>
<input type="text" name="postcode" class="form-control" value="{{ old('postcode') }}">
</div>

</div>

</div>
</div>


<div class="text-end mb-5">
<button class="btn btn-success px-4">💾 บันทึกข้อมูล</button>
<a href="{{ route('customers.index') }}" class="btn btn-secondary">ยกเลิก</a>
</div>

</form>

</div>

@endsection
