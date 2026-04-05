@extends('layouts.app')

@section('title', 'เพิ่มบริษัท')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 font-weight-bold text-primary">🏢 เพิ่มบริษัท</h3>
        <small class="text-muted">Create Company</small>
    </div>

    <a href="{{ route('companies.index') }}" class="btn btn-secondary shadow-sm">
        ← กลับ
    </a>
</div>

<div class="glass-card p-4 shadow-sm">

    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            {{-- ชื่อบริษัท --}}
            <div class="col-md-6 mb-3">
                <label>ชื่อบริษัท *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- เลขภาษี --}}
            <div class="col-md-6 mb-3">
                <label>เลขผู้เสียภาษี *</label>
                <input type="text" name="tax_id" maxlength="13"
                       class="form-control tax-id"
                       value="{{ old('tax_id') }}" required>
                @error('tax_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- ประเภทธุรกิจ --}}
            <div class="col-md-6 mb-3">
                <label>ประเภทธุรกิจ *</label>
                <select name="business_type" class="form-control" required>
                    <option value="">-- เลือก --</option>
                    <option value="บุคคลธรรมดา" {{ old('business_type')=='บุคคลธรรมดา'?'selected':'' }}>บุคคลธรรมดา</option>
                    <option value="ห้างหุ้นส่วน" {{ old('business_type')=='ห้างหุ้นส่วน'?'selected':'' }}>ห้างหุ้นส่วน</option>
                    <option value="บริษัทจำกัด" {{ old('business_type')=='บริษัทจำกัด'?'selected':'' }}>บริษัทจำกัด</option>
                    <option value="บริษัทมหาชน" {{ old('business_type')=='บริษัทมหาชน'?'selected':'' }}>บริษัทมหาชน</option>
                </select>
            </div>

            {{-- ประเภทอุตสาหกรรม --}}
            <div class="col-md-6 mb-3">
                <label>ประเภทอุตสาหกรรม *</label>
                <select name="industry_type" class="form-control" required>
                    <option value="">-- เลือก --</option>
                    <option value="การผลิต" {{ old('industry_type')=='การผลิต'?'selected':'' }}>การผลิต</option>
                    <option value="การค้า" {{ old('industry_type')=='การค้า'?'selected':'' }}>การค้า</option>
                    <option value="บริการ" {{ old('industry_type')=='บริการ'?'selected':'' }}>บริการ</option>
                    <option value="ก่อสร้าง" {{ old('industry_type')=='ก่อสร้าง'?'selected':'' }}>ก่อสร้าง</option>
                    <option value="เทคโนโลยี" {{ old('industry_type')=='เทคโนโลยี'?'selected':'' }}>เทคโนโลยี</option>
                </select>
            </div>

            {{-- ประเภทสินค้า --}}
            <div class="col-md-6 mb-3">
                <label>ประเภทสินค้า</label>
                <input type="text" name="product_type" class="form-control"
                       value="{{ old('product_type') }}">
            </div>

            {{-- จำนวนพนักงาน --}}
            <div class="col-md-6 mb-3">
                <label>จำนวนพนักงาน *</label>
                <input type="number" name="employee_count" min="0"
                       class="form-control"
                       value="{{ old('employee_count',0) }}" required>
            </div>

            {{-- โทรศัพท์ --}}
            <div class="col-md-6 mb-3">
                <label>เบอร์โทร</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone') }}">
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}">
            </div>

            {{-- ที่อยู่ --}}
            <div class="col-12 mb-3">
                <label>ที่อยู่</label>
                <textarea name="address" rows="3"
                          class="form-control">{{ old('address') }}</textarea>
            </div>

            {{-- Logo --}}
            <div class="col-12 mb-4">
                <label>โลโก้บริษัท</label>
                <input type="file" name="logo" class="form-control-file" onchange="previewLogo(event)">
                <div class="mt-2">
                    <img id="logo-preview" style="max-height:80px; display:none;">
                </div>
            </div>

        </div>

        <div class="text-right">
            <button class="btn btn-primary btn-modern2 px-4">
                💾 บันทึกข้อมูล
            </button>
        </div>

    </form>

</div>

{{-- JS --}}
<script>
function previewLogo(event) {
    const img = document.getElementById('logo-preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}

// format tax id (เลข 13 หลัก)
document.querySelector('.tax-id').addEventListener('input', function(e){
    this.value = this.value.replace(/[^0-9]/g,'').slice(0,13);
});
</script>

@endsection
