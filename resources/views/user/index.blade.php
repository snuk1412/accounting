<?php
use App\Models\CmsHelper as Cms;
?>

@extends('layouts.app')

@section('title', 'ผู้ใช้งาน')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">👤 ผู้ใช้งานระบบ</h3>
      <small class="text-muted">User Management</small>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
      + เพิ่มผู้ใช้งาน
    </a>
  </div>


  <form method="GET" class="mb-3">

    <div class="row g-2">

      {{-- search --}}
      <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="🔍 ค้นหาชื่อ / email">
      </div>

      {{-- role --}}
      <div class="col-md-3">
        <select name="role" class="form-control">
          <option value="">-- ทุกสิทธิ์ --</option>
          <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
          <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
        </select>
      </div>

      {{-- company --}}
      <div class="col-md-3">
        <select name="company_id" class="form-control">
          <option value="">-- ทุกบริษัท --</option>

          @foreach ($companies as $company)
            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
              {{ $company->name }}
            </option>
          @endforeach

        </select>
      </div>

      {{-- button --}}
      <div class="col-md-2 d-flex gap-1">

        <button class="btn btn-primary w-100 mr-2">
          ค้นหา
        </button>

        <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">
          ล้าง
        </a>

      </div>

    </div>

  </form>

  <div class="card card-modern border-0 shadow-sm">
    <div class="card-body p-0">

      <div class="table-responsive">

        <table class="table table-bordered align-middle mb-0 table-striped">

          <thead>
            <tr>
              <th class="pl-4" width="50">#</th>
              <th class="text-center">รูปภาพ</th>
              <th>ชื่อ</th>
              <th>Email</th>
              <th>บริษัท</th>
              <th class=" text-center">สิทธิ</th>
              <th class="text-center pr-4" width="160">จัดการ</th>
            </tr>
          </thead>

          <tbody>

            @forelse($users as $key => $user)
              <tr>

                <td class="pl-4 align-middle">
                  <span class="badge badge-light">
                    {{ $key + 1 }}
                  </span>
                </td>

                <td class="align-middle text-center">
                  <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . $user->name }}" class="img-fluid img-circle shadow-sm" style="width:50px;height:50px;object-fit:contain;">
                </td>

                <td class="align-middle font-weight-bold">
                  {{ $user->name }}
                </td>

                <td class="align-middle">
                  {{ $user->email }}
                </td>

                <td class="align-middle">
                  {{ Cms::CompanyName($user->companies_id) }}
                </td>

                <td class="align-middle text-center">
                  @if ($user->role == 'admin')
                    <span class="badge bg-danger">Admin</span>
                  @elseif($user->role == 'manager')
                    <span class="badge bg-warning text-dark">Manager</span>
                  @else
                    <span class="badge bg-secondary">User</span>
                  @endif
                </td>

                <td class="align-middle text-center pr-4">

                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning mr-1">
                    <span class="fas fa-edit"></span>
                  </a>

                  <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;" class="delete-form">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-sm btn-danger btn-delete">
                      <span class="fas fa-trash"></span>
                    </button>
                  </form>

                </td>

              </tr>

            @empty

              <tr>
                <td colspan="6" class="text-center py-4 text-muted">
                  ไม่มีข้อมูลผู้ใช้งาน
                </td>
              </tr>
            @endforelse

          </tbody>

        </table>
        <div class="d-flex justify-content-between align-items-center mt-3 px-3">

          <div>
            แสดง {{ $users->firstItem() }} ถึง {{ $users->lastItem() }}
            จาก {{ $users->total() }} รายการ
          </div>

          <div>
            {{ $users->links() }}
          </div>

        </div>
      </div>

    </div>
  </div>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {

        const form = this.closest('form');

        Swal.fire({
          title: 'ยืนยันการลบ?',
          text: "ข้อมูลนี้จะไม่สามารถกู้คืนได้",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'ลบเลย',
          cancelButtonText: 'ยกเลิก'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });

      });
    });

  });
</script>
