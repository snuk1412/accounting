@extends('layouts.app')

@section('title','เพิ่มผู้ใช้งาน')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 font-weight-bold text-primary">👤 เพิ่มผู้ใช้งาน</h3>
        <small class="text-muted">Create User</small>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        กลับ
    </a>
</div>

<div class="card card-modern border-0 shadow-sm">
    <div class="card-body">

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>ชื่อผู้ใช้งาน</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
<div class="form-group">

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

<div class="invalid-feedback">
    {{ $message }}
</div>

@enderror

</div>
<div class="form-group">
    <label>สิทธิ์ผู้ใช้ </label>
    <select name="role" class="form-control @error('role') is-invalid @enderror">
        <option value="admin">Admin</option>
        <option value="user">User</option>
         <option value="user">Manager</option>
    </select>

    @error('role')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>


            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="btn btn-primary mt-3">
                บันทึกข้อมูล
            </button>

        </form>

    </div>
</div>

@endsection
