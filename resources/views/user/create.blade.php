@extends('layouts.app')

@section('title', 'เพิ่มผู้ใช้งาน')

@section('content')

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary">➕ เพิ่มผู้ใช้งาน</h4>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">กลับ</a>
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

      <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

          {{-- LEFT: Avatar --}}
          <div class="col-md-4 text-center">

            <img id="preview"
              src="https://ui-avatars.com/api/?name=User"
              class="img-fluid rounded shadow-sm mb-2"
              style="width:250px;height:250px;object-fit:contain;">

            <input type="file" name="avatar" class="form-control mt-2" onchange="previewImage(event)">

            @error('avatar')
              <div class="text-danger small">{{ $message }}</div>
            @enderror

          </div>

          {{-- RIGHT --}}
          <div class="col-md-8">

            {{-- TABS --}}
            <ul class="nav nav-tabs mb-3">
              <li class="nav-item">
                <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                  ข้อมูลทั่วไป
                </button>
              </li>

              <li class="nav-item">
                <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#password">
                  ตั้งรหัสผ่าน
                </button>
              </li>
            </ul>

            <div class="tab-content">

              {{-- TAB INFO --}}
              <div class="tab-pane fade show active" id="info">

                {{-- NAME --}}
                <div class="mb-3">
                  <label>ชื่อ</label>
                  <input type="text" name="name" placeholder="กรอกชื่อ"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror">

                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror">

                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- COMPANY --}}
                <div class="mb-3">
                  <label>บริษัท</label>
                  <select name="companies_id"
                    class="form-control @error('companies_id') is-invalid @enderror">

                    <option value="">-- เลือกบริษัท --</option>

                    @foreach ($companies as $company)
                      <option value="{{ $company->id }}"
                        {{ old('companies_id') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                      </option>
                    @endforeach

                  </select>

                  @error('companies_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- ROLE --}}
                <div class="mb-3">
                  <label>สิทธิ์</label>
                  <select name="role"
                    class="form-control @error('role') is-invalid @enderror">

                    <option value="">-- เลือกสิทธิ์ --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>

                  </select>

                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

              </div>

              {{-- TAB PASSWORD --}}
              <div class="tab-pane fade" id="password">

                {{-- PASSWORD --}}
                <div class="mb-3 mt-3">
                  <label>รหัสผ่าน</label>
                  <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror">

                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- CONFIRM --}}
                <div class="mb-3">
                  <label>ยืนยันรหัสผ่าน</label>
                  <input type="password" name="password_confirmation"
                    class="form-control">

                </div>

              </div>

            </div>

          </div>

        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary mt-3">
            💾 บันทึกข้อมูล
          </button>
        </div>

      </form>

    </div>
  </div>

</div>

{{-- IMAGE PREVIEW --}}
<script>
function previewImage(e) {
  const reader = new FileReader();
  reader.onload = function () {
    document.getElementById('preview').src = reader.result;
  }
  reader.readAsDataURL(e.target.files[0]);
}
</script>

@endsection
