@extends('layouts.app')
@section('title', 'ใบแจ้งหนี้')

@section('content')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    .card-glass {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease;
    }

    .card-glass:hover {
      transform: translateY(-5px);
    }

    .btn-modern {
      border-radius: 12px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .table-modern thead th {
      border-top: none;
      color: #64748b;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
    }

    .badge-emerald {
      background-color: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
  </style>

  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-0 font-weight-bold text-dark">🧾 รายการใบแจ้งหนี้</h3>
        <p class="text-muted small">จัดการข้อมูลรายการซื้อ-ขายและสถานะการชำระเงิน</p>
      </div>
      <a href="{{ route('invoice.create') }}" class="btn btn-success btn-modern shadow-sm">
        <i class="fas fa-plus-circle me-1"></i> สร้างใบแจ้งหนี้
      </a>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card-glass p-4 text-white" style="background: linear-gradient(135deg, #10b981, #34d399);">
          <small class="opacity-75">จำนวนรายการ</small>
          <h3 class="font-weight-bold">{{ number_format($data->total()) }} รายการ</h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-glass p-4 text-white" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
          <small class="opacity-75">ยอดรวมทั้งหมด</small>
          <h3 class="font-weight-bold">฿ {{ number_format($data->sum('total'), 2) }}</h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-glass p-4 text-white" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
          <small class="opacity-75">ชำระแล้ว (เฉพาะงานขาย)</small>
          <h3 class="font-weight-bold">฿ {{ number_format($data->where('type', 'sale')->sum('paid'), 2) }}</h3>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-glass p-4 text-white" style="background: linear-gradient(135deg, #ef4444, #f87171);">
          <small class="opacity-75">คงเหลือ (เฉพาะงานขาย)</small>
          <h3 class="font-weight-bold">฿ {{ number_format($data->where('type', 'sale')->sum('balance'), 2) }}</h3>
        </div>
      </div>
    </div>

  {{-- Filter Section --}}
<div class="card-glass p-4 mb-4">
    <form method="GET" action="{{ route('invoice.index') }}">
        <div class="row g-3">
            {{-- แถวที่ 1: ตัวเลือกการกรอง --}}
            <div class="col-md-3">
                <label class="small font-weight-bold text-secondary mb-1">
                    <i class="fas fa-search me-1"></i> ค้นหาลูกค้า
                </label>
                <input type="text" name="customer" class="form-control form-control-modern" placeholder="ชื่อลูกค้า..." value="{{ request('customer') }}">
            </div>

            <div class="col-md-2">
                <label class="small font-weight-bold text-secondary mb-1">
                    <i class="fas fa-filter me-1"></i> ประเภท
                </label>
                <select name="type" class="form-control form-control-modern">
                    <option value="">ทั้งหมด</option>
                    <option value="sale" {{ request('type') === 'sale' ? 'selected' : '' }}>รายการขาย</option>
                    <option value="purchase" {{ request('type') === 'purchase' ? 'selected' : '' }}>รายการซื้อ</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="small font-weight-bold text-secondary mb-1">
                    <i class="fas fa-info-circle me-1"></i> สถานะ
                </label>
                <select name="status" class="form-control form-control-modern">
                    <option value="">ทั้งหมด</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>ชำระครบ</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>ค้างชำระ</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="small font-weight-bold text-secondary mb-1">
                    <i class="fas fa-calendar-alt me-1"></i> ช่วงวันที่
                </label>
                <div class="input-group">
                    <input type="date" name="date_from" id="date_from" class="form-control form-control-modern" value="{{ request('date_from') }}">
                    <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">ถึง</span>
                    <input type="date" name="date_to" id="date_to" class="form-control form-control-modern" value="{{ request('date_to') }}">
                </div>
            </div>

            {{-- แถวที่ 2: ปุ่มจัดการ --}}
           <div class="col-12 d-flex justify-content-end mt-3">
                <a href="{{ route('purchase.pdf') }}" class="btn btn-light btn-modern px-4 me-2 border">
                    <i class="fas fa-sync-alt me-1"></i> ภาษีซื้อ
                </a>
                        <a href="{{ route('sale.pdf') }}" class="btn btn-light btn-modern px-4 me-2 border">
                    <i class="fas fa-sync-alt me-1"></i> ภาษีขาย
                </a>
                        <a href="{{ route('invoice.index') }}" class="btn btn-light btn-modern px-4 me-2 border">
                    <i class="fas fa-sync-alt me-1"></i> รีเซ็ต
                </a>

                <button type="submit" class="btn btn-primary btn-modern px-5 shadow-sm">
                    <i class="fas fa-filter me-1"></i> กรองข้อมูล
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    /* เพิ่มเติมเพื่อให้ดูละมุนขึ้น */
    .form-control-modern {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        transition: all 0.2s;
    }
    .form-control-modern:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .input-group-text {
        border-radius: 0;
    }
    /* ปรับปุ่มให้โค้งมนรับกับฟอร์ม */
    .btn-modern {
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
    }
</style>

    {{-- Table Section --}}
    <div class="card-glass p-0 overflow-hidden">
      <div class="table-responsive">
        <table class="table table-hover table-modern mb-0">
          <thead class="bg-light">
            <tr>
              <th class="px-4 py-3">เลขที่</th>
              <th>ลูกค้า</th>
              <th class="text-center">ประเภท</th>
              <th class="text-right">ยอดรวม</th>
              <th class="text-right">ชำระแล้ว</th>
              <th class="text-right">คงเหลือ</th>
              <th class="text-center">ครบกำหนด</th>
              <th class="text-center">สถานะ</th>
              <th class="text-center">จัดการ</th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $row)
              <tr class="align-middle">
                <td class="px-4 font-weight-bold text-dark">{{ $row->invoice_no }}</td>
                <td>
                  <div class="font-weight-bold text-dark">{{ $row->customer->name ?? 'N/A' }}</div>
                  <small class="text-muted">{{ $row->customer->tax_id ?? '' }}</small>
                </td>
                <td class="text-center">
                  @if ($row->type === 'sale')
                    <span class="badge bg-primary-soft text-primary px-2 py-1">SALE</span>
                  @else
                    <span class="badge bg-secondary-soft text-secondary px-2 py-1">PURCHASE</span>
                  @endif
                </td>
                <td class="text-right font-weight-bold text-primary">฿{{ number_format($row->total, 2) }}</td>
                <td class="text-right text-success">
                  {{ $row->type == 'sale' ? '฿' . number_format($row->paid, 2) : '-' }}
                </td>
                <td class="text-right text-danger">
                  {{ $row->type == 'sale' ? '฿' . number_format($row->balance, 2) : '-' }}
                </td>
                <td class="text-center small">
                  {{ \Carbon\Carbon::parse($row->due_date)->locale('th')->addYears(543)->isoFormat('D MMM YY') }}
                </td>
                <td class="text-center">
                  @if ($row->type == 'sale')
                    @if ($row->paid >= $row->total && $row->total > 0)
                      <span class="badge rounded-pill badge-emerald px-3 py-2">ชำระครบ</span>
                    @elseif($row->paid > 0)
                      <span class="badge rounded-pill bg-warning-soft text-warning px-3 py-2">บางส่วน</span>
                    @else
                      <span class="badge rounded-pill bg-danger-soft text-danger px-3 py-2">ค้างชำระ</span>
                    @endif
                  @else
                    <span class="text-muted small">N/A</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="btn-group">
                    @if ($row->type == 'sale')
                      <a href="{{ route('invoice.pdf', $row->id) }}" target="_blank" class="btn btn-sm btn-success" data-toggle="tooltip" title="PDF">
                        <i class="fas fa-file-pdf"></i>
                      </a>
                    @endif
                    <a href="{{ route('invoice.edit', $row->id) }}" class="btn btn-sm btn-warning mx-1" data-toggle="tooltip" title="แก้ไข">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('invoice.destroy', $row->id) }}" onsubmit="return confirm('ยืนยันการลบ?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="ลบ">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center py-5 text-muted">ไม่พบข้อมูลที่ค้นหา</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-between align-items-center p-4 bg-light">
        <div class="small text-muted">
          แสดง {{ $data->firstItem() ?? 0 }} ถึง {{ $data->lastItem() ?? 0 }} จาก {{ $data->total() }} รายการ
        </div>
        <div>{{ $data->appends(request()->query())->links() }}</div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();

      let dateFrom = document.getElementById('date_from');
      let dateTo = document.getElementById('date_to');

      dateFrom.addEventListener('change', function() {
        if (this.value) {
          dateTo.min = this.value;
          if (dateTo.value && dateTo.value < this.value) {
            dateTo.value = this.value;
          }
        }
      });
    });
  </script>
@endsection
