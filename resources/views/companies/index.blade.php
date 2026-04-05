@extends('layouts.app')

@section('title', 'บริษัท')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 font-weight-bold text-primary">🏢 บริษัท</h3>
        <small class="text-muted">Company Management</small>
    </div>

    <a href="{{ route('companies.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
        + เพิ่มบริษัท
    </a>
</div>

<div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-bordered table-modern align-middle mb-0 table-hover">

            <thead style="background:#f8fafc;">
                <tr>
                    <th class="pl-4">โลโก้</th>
                    <th>ชื่อบริษัท</th>
                    <th>เลขผู้เสียภาษี</th>
                    <th class="text-center">Default</th>
                    <th class="text-center pr-4" width="150">จัดการ</th>
                </tr>
            </thead>

            <tbody>
                @forelse($companies as $c)
                <tr>

                   <td class="pl-4">
    @if($c->logo)
        <img src="{{ asset($c->logo) }}"
             width="50"
             class="rounded shadow-sm">
    @else
        <span class="text-muted">-</span>
    @endif
</td>

                    <td>{{ $c->name }}</td>

                    <td>
                        {{ substr($c->tax_id,0,1).'-'.substr($c->tax_id,1,4).'-'.substr($c->tax_id,5,4).'-'.substr($c->tax_id,9,2).'-'.substr($c->tax_id,11,1) }}
                    </td>

                    <td class="text-center">
                        @if($c->is_default)
                            <span class="badge badge-success">หลัก</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td class="text-center text-nowrap pr-4">

                        <a href="{{ route('companies.edit',$c->id) }}"
                           class="btn btn-sm btn-warning mr-1">
                            แก้ไข
                        </a>

                        <form action="{{ route('companies.destroy',$c->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('ลบข้อมูลบริษัทนี้?')">
                                ลบ
                            </button>
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        ไม่มีข้อมูลบริษัท
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

        {{-- pagination (ถ้ามี) --}}
        @if(method_exists($companies, 'links'))
        <div class="d-flex justify-content-between align-items-center mt-3 px-3">
            <div>
                แสดง {{ $companies->firstItem() }} ถึง {{ $companies->lastItem() }}
                จาก {{ $companies->total() }} รายการ
            </div>

            <div>
                {{ $companies->links() }}
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
