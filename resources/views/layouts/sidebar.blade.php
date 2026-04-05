<div class="sidebar">

  <!-- ===== Dashboard (เห็นทุกคน) ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      📊 ภาพรวม
    </div>
    <div class="menu-items">

      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> <span>Dashboard</span>
      </a>

    </div>
  </div>

  <!-- ===== เมนูอื่น (ต้อง login เท่านั้น) ===== -->
  @auth

  <!-- ===== ลูกค้า / การขาย ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      🧾 ลูกค้า / การขาย
    </div>
    <div class="menu-items">
      <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> <span>ลูกค้า</span>
      </a>
    </div>
  </div>

  <!-- ===== การซื้อ / การขาย ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      🧾 การซื้อ / การขาย
    </div>
    <div class="menu-items">
      <a href="{{ route('invoice.index') }}" class="{{ request()->routeIs('invoice.*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice"></i> <span>ใบแจ้งหนี้</span>
      </a>
    </div>
  </div>

  <!-- ===== การเงิน ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      💰 การเงิน
    </div>
    <div class="menu-items">
      <a href="{{ route('banks.index') }}" class="{{ request()->routeIs('banks.*') ? 'active' : '' }}">
        <i class="fas fa-university"></i> <span>บัญชีธนาคาร</span>
      </a>
    </div>
  </div>

  <!-- ===== ระบบบัญชี ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      📚 ระบบบัญชี
    </div>
    <div class="menu-items">
      <a href="{{ route('accounts.index') }}" class="{{ request()->routeIs('accounts.*') ? 'active' : '' }}">
        <i class="fas fa-book"></i> <span>ผังบัญชี</span>
      </a>

      <a href="{{ route('journals.index') }}" class="{{ request()->routeIs('journals.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> <span>สมุดรายวัน</span>
      </a>
    </div>
  </div>

  <!-- ===== ตั้งค่า ===== -->
  <div class="menu-group">
    <div class="menu-header toggle">
      ⚙️ ตั้งค่า
    </div>
    <div class="menu-items">
      <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="fas fa-user"></i> <span>ผู้ใช้งาน</span>
      </a>
      <a href="{{ route('companies.index') }}" class="{{ request()->routeIs('journals.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list"></i> <span>บริษัท</span>
      </a>
    </div>
  </div>

  @endauth

</div>
