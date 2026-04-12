@extends('layouts.app')
@section('title', 'ผังบัญชี')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 font-weight-bold">📊 ผังบัญชี</h3>
        <small class="text-muted">ระบบบัญชีคู่ (Double Entry)</small>
    </div>

    <div>
        <a href="{{ route('accounts.create') }}"
           class="btn btn-primary btn-modern2 shadow-sm">
            + เพิ่มบัญชี
        </a>
    </div>
</div>

<div class="glass-card p-0 shadow-sm">

<div class="table-responsive">

<table class="table table-bordered table-modern align-middle mb-0 table-hover">

<thead>
<tr>
    <th class="text-center">รหัสบัญชี</th>
    <th>ชื่อบัญชี</th>
    <th>ประเภท</th>
    <th class="text-right">ยอดคงเหลือ</th>
    <th class="text-center" width="150">จัดการ</th>
</tr>
</thead>

<tbody>

@forelse ($accounts ?? [] as $account)

<tr>
    <td class="text-center">
        {{ $account->code ?? '-' }}
    </td>

    <td>
        {{ $account->name ?? '-' }}
    </td>

    <td>
        {{ $account->type ?? '-' }}
    </td>

    <td class="text-right">
        {{ number_format((float)($account->balance ?? 0), 2) }}
    </td>

    <td class="text-center text-nowrap">

        <a href="{{ route('accounts.edit', $account->id) }}"
           class="btn btn-sm btn-warning">
            แก้ไข
        </a>

        <form action="{{ route('accounts.destroy', $account->id) }}"
              method="POST"
              style="display:inline;"
              onsubmit="return confirmDelete(this)">

            @csrf
            @method('DELETE')

            <button class="btn btn-sm btn-danger">
                ลบ
            </button>

        </form>

    </td>
</tr>

{{-- children --}}
@if (!empty($account->children) && $account->children->count())

@foreach ($account->children as $child)

<tr>

    <td class="text-center">
        {{ $child->code ?? '-' }}
    </td>

    <td>
        &nbsp;&nbsp;&nbsp;&nbsp; └─
        {{ $child->name ?? '-' }}
    </td>

    <td>
        {{ $child->type ?? '-' }}
    </td>

    <td class="text-right">
        {{ number_format((float)($child->balance ?? 0), 2) }}
    </td>

    <td class="text-center text-nowrap">

        <a href="{{ route('accounts.edit', $child->id) }}"
           class="btn btn-sm btn-warning">
            แก้ไข
        </a>

        <form action="{{ route('accounts.destroy', $child->id) }}"
              method="POST"
              style="display:inline;"
              onsubmit="return confirmDelete(this)">

            @csrf
            @method('DELETE')

            <button class="btn btn-sm btn-danger">
                ลบ
            </button>

        </form>

    </td>

</tr>

@endforeach
@endif

@empty

<tr>
<td colspan="5"
    class="text-center text-muted py-4">
    ไม่พบข้อมูลบัญชี
</td>
</tr>

@endforelse

</tbody>
</table>

{{-- Pagination --}}
@if(method_exists($accounts,'links'))

<div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">

<div>
แสดง
{{ $accounts->firstItem() ?? 0 }}
ถึง
{{ $accounts->lastItem() ?? 0 }}

จาก
{{ $accounts->total() ?? 0 }}
รายการ
</div>

<div>
{{ $accounts->links() }}
</div>

</div>

@endif

</div>
</div>

@endsection


{{-- confirm delete --}}
@push('scripts')

<script>

function confirmDelete(form)
{
    if(confirm('ต้องการลบข้อมูลนี้หรือไม่ ?'))
    {
        return true;
    }

    return false;
}

</script>

@endpush
