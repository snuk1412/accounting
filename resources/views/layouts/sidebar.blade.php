<style>
    /* Sidebar Styling */
.sidebar {
    background-color: #ffffff;
    border-right: 1px solid #e2e8f0;
    min-height: 100vh;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    margin: 4px 10px;
    border-radius: 12px;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
}

.nav-link:hover {
    background-color: #f0fdf4; /* เขียวพาสเทลอ่อนมาก */
    color: #10b981;
}

.nav-link.active {
    background-color: #10b981; /* เขียวหลัก */
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
}

.nav-link i {
    width: 25px;
    font-size: 1.1rem;
}

.menu-header {
    letter-spacing: 0.5px;
    font-size: 0.75rem;
    margin-top: 10px;
}
</style>
<div class="sidebar py-3 px-2">

  <div class="menu-group mb-3">
    <div class="menu-header px-3 py-2 small text-uppercase fw-bold text-muted">
      📊 ภาพรวม
    </div>
    <div class="menu-items">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large me-2"></i> <span>หน้าแรก </span>
      </a>
    </div>
  </div>

  @auth

  <div class="menu-group mb-3">
    <div class="menu-header px-3 py-2 small text-uppercase fw-bold text-muted">
      🤝 การขาย / ลูกค้า
    </div>
    <div class="menu-items">
      <a href="{{ route('customers.index') }}" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
        <i class="fas fa-address-card me-2"></i> <span>ข้อมูลลูกค้า</span>
      </a>
      <a href="{{ route('invoice.index') }}" class="nav-link {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice-dollar me-2"></i> <span>รายการซื้อ-ขาย</span>
      </a>
    </div>
  </div>

  <div class="menu-group mb-3">
    <div class="menu-header px-3 py-2 small text-uppercase fw-bold text-muted">
      💰 การเงิน
    </div>
    <div class="menu-items">
      <a href="{{ route('banks.index') }}" class="nav-link {{ request()->routeIs('banks.*') ? 'active' : '' }}">
        <i class="fas fa-university me-2"></i> <span>บัญชีธนาคาร</span>
      </a>
    </div>
  </div>

  <div class="menu-group mb-3">
    <div class="menu-header px-3 py-2 small text-uppercase fw-bold text-muted">
      📚 ระบบบัญชี
    </div>
    <div class="menu-items">
      <a href="{{ route('accounts.index') }}" class="nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
        <i class="fas fa-list-ol me-2"></i> <span>ผังบัญชี </span>
      </a>
      <a href="{{ route('journals.index') }}" class="nav-link {{ request()->routeIs('journals.*') ? 'active' : '' }}">
        <i class="fas fa-history me-2"></i> <span>สมุดรายวันทั่วไป</span>
      </a>
    </div>
  </div>

  <div class="menu-group mb-3">
    <div class="menu-header px-3 py-2 small text-uppercase fw-bold text-muted">
      ⚙️ ตั้งค่าระบบ
    </div>
    <div class="menu-items">
      <a href="{{ route('companies.index') }}" class="nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}">
        <i class="fas fa-building me-2"></i> <span>ข้อมูลบริษัท</span>
      </a>
      <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="fas fa-user-shield me-2"></i> <span>จัดการผู้ใช้งาน</span>
      </a>
    </div>
  </div>

  @endauth

</div>
