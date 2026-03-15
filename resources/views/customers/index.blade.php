@extends('layouts.app')

@section('title','ลูกค้า')

@section('content')



<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold text-primary">👤 รายชื่อลูกค้า</h3>
        <small class="text-muted">Customer Management</small>
    </div>

    <a href="{{ route('customers.create') }}" class="btn btn-primary shadow-sm">
        + เพิ่มลูกค้า
    </a>
</div>


<div class="card border-0 shadow-sm">
<div class="card-body p-0">

<table class="table table-bordered table-hover table-striped mb-0">
<thead class="table-light">
<tr>
    <th width="4%" class="text-center">ลำดับ</th>
    <th width="15%">เลขประจำตัวผู้เสียภาษี</th>
    <th width="40%">ชื่อผู้ประกอบการ / ลูกค้า</th>
    <th width="15%">เบอร์ติดต่อ</th>
    <th width="15%" class="text-center">จัดการ</th>
</tr>
</thead>

<tbody>

@forelse($customers as $row)

<tr>

<td class="align-middle text-center">
<span class="badge bg-light text-dark">
{{ $loop->iteration + ($customers->currentPage()-1)*$customers->perPage() }}
</span>
</td>

<td class="align-middle text-nowrap">

@if(strlen($row->tax_id)==13)
{{ substr($row->tax_id,0,1) }}-
{{ substr($row->tax_id,1,4) }}-
{{ substr($row->tax_id,5,5) }}-
{{ substr($row->tax_id,10,2) }}-
{{ substr($row->tax_id,12,1) }}
@else
{{ $row->tax_id }}
@endif

</td>

<td class="align-middle">

ชื่อผู้ประกอบการ :
<strong>{{ $row->business_name }}</strong>
<br>

ลูกค้า :
<small class="text-muted">{{ $row->fullname }}</small>

</td>

<td class="align-middle text-nowrap">
{{ $row->phone }}
</td>

<td class="align-middle text-center">

<a href="{{ route('customers.edit',$row->id) }}"
class="btn btn-warning btn-sm">
แก้ไข
</a>

<form method="POST"
action="{{ route('customers.destroy',$row->id) }}"
class="d-inline delete-form">

@csrf
@method('DELETE')

<button type="button"
class="btn btn-sm btn-outline-danger btn-delete">
ลบ
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center py-4 text-muted">
ไม่มีข้อมูลลูกค้า
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>


<div class="mt-3">
{{ $customers->links() }}
</div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

const deleteButtons = document.querySelectorAll('.btn-delete');

deleteButtons.forEach(button => {

button.addEventListener('click', function(){

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

if(result.isConfirmed){
form.submit();
}

});

});

});

});

</script>

@endpush
