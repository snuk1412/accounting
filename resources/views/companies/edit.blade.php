@extends('layouts.app')

@section('title', 'แก้ไขบริษัท')

@section('content')

  <div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold text-warning">✏️ แก้ไขบริษัท</h4>
      <a href="{{ route('companies.index') }}" class="btn btn-secondary">กลับ</a>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">

        {{-- ERROR --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">

            {{-- LEFT: LOGO --}}
            <div class="col-md-4 text-center">

              <img id="logoPreview" src="{{ $company->logo ? asset($company->logo) : 'https://ui-avatars.com/api/?name=' . $company->name }}" class="img-fluid rounded shadow-sm mb-2" style="width:250px;height:250px;object-fit:contain;">

              <input type="file" name="logo" class="form-control mt-2" onchange="previewLogo(event)">

              @error('logo')
                <div class="text-danger small">{{ $message }}</div>
              @enderror

            </div>

            {{-- RIGHT --}}
            <div class="col-md-8">

              {{-- TABS --}}
              <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                  <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                    ข้อมูลบริษัท
                  </button>
                </li>

                <li class="nav-item">
                  <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#contact">
                    ติดต่อ
                  </button>
                </li>
              </ul>

              <div class="tab-content">

                {{-- TAB INFO --}}
                <div class="tab-pane fade show active" id="info">

                  {{-- NAME --}}
                  <div class="mb-3">
                    <label>ชื่อบริษัท *</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" class="form-control @error('name') is-invalid @enderror">

                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- TAX ID --}}
                  <div class="mb-3">
                    <label>เลขผู้เสียภาษี *</label>
                    <input type="text" name="tax_id" value="{{ old('tax_id', $company->tax_id) }}" maxlength="13" class="form-control tax-id @error('tax_id') is-invalid @enderror">

                    @error('tax_id')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- BUSINESS TYPE --}}
                  <div class="mb-3">
                    <label>ประเภทธุรกิจ *</label>
                    <select name="business_type" class="form-control @error('business_type') is-invalid @enderror">

                      <option value="">-- เลือก --</option>
                      <option value="บุคคลธรรมดา" {{ old('business_type', $company->business_type) == 'บุคคลธรรมดา' ? 'selected' : '' }}>บุคคลธรรมดา</option>
                      <option value="ห้างหุ้นส่วน" {{ old('business_type', $company->business_type) == 'ห้างหุ้นส่วน' ? 'selected' : '' }}>ห้างหุ้นส่วน</option>
                      <option value="บริษัทจำกัด" {{ old('business_type', $company->business_type) == 'บริษัทจำกัด' ? 'selected' : '' }}>บริษัทจำกัด</option>
                      <option value="บริษัทมหาชน" {{ old('business_type', $company->business_type) == 'บริษัทมหาชน' ? 'selected' : '' }}>บริษัทมหาชน</option>

                    </select>

                    @error('business_type')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- INDUSTRY --}}
                  <div class="mb-3">
                    <label>ประเภทอุตสาหกรรม *</label>
                    <select name="industry_type" class="form-control @error('industry_type') is-invalid @enderror">

                      <option value="">-- เลือก --</option>
                      <option value="การผลิต" {{ old('industry_type', $company->industry_type) == 'การผลิต' ? 'selected' : '' }}>การผลิต</option>
                      <option value="การค้า" {{ old('industry_type', $company->industry_type) == 'การค้า' ? 'selected' : '' }}>การค้า</option>
                      <option value="บริการ" {{ old('industry_type', $company->industry_type) == 'บริการ' ? 'selected' : '' }}>บริการ</option>
                      <option value="ก่อสร้าง" {{ old('industry_type', $company->industry_type) == 'ก่อสร้าง' ? 'selected' : '' }}>ก่อสร้าง</option>
                      <option value="เทคโนโลยี" {{ old('industry_type', $company->industry_type) == 'เทคโนโลยี' ? 'selected' : '' }}>เทคโนโลยี</option>

                    </select>

                    @error('industry_type')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- PRODUCT --}}
                  <div class="mb-3">
                    <label>ประเภทสินค้า</label>
                    <input type="text" name="product_type" value="{{ old('product_type', $company->product_type) }}" class="form-control">
                  </div>

                  {{-- EMPLOYEE --}}
                  <div class="mb-3">
                    <label>จำนวนพนักงาน *</label>
                    <input type="number" name="employee_count" value="{{ old('employee_count', $company->employee_count) }}" class="form-control">
                  </div>

                </div>

                {{-- TAB CONTACT --}}
                <div class="tab-pane fade" id="contact">

                  {{-- PHONE --}}
                  <div class="mb-3 mt-3">
                    <label>เบอร์โทร</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="form-control">
                  </div>

                  {{-- EMAIL --}}
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $company->email) }}" class="form-control">
                  </div>

                  {{-- ADDRESS --}}
                  <div class="mb-3">
                    <label>ที่อยู่</label>
                    <textarea name="address" rows="3" class="form-control">{{ old('address', $company->address) }}</textarea>
                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="d-flex justify-content-end">
            <button class="btn btn-warning mt-3">
              💾 อัปเดตข้อมูล
            </button>
          </div>

        </form>

      </div>
    </div>

  </div>

  {{-- SCRIPT --}}
  <script>
    function previewLogo(event) {
      const img = document.getElementById('logoPreview');
      img.src = URL.createObjectURL(event.target.files[0]);
    }

    document.querySelector('.tax-id')?.addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);
    });
  </script>

@endsection
