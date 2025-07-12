<style>
/* Sidebar Header Styles */
.sidebar-brand-wrapper {
    padding: 15px 20px; /* Balanced padding */
    transition: background 0.3s ease; /* Smooth transition for hover */
}

.sidebar-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: transform 0.2s ease, opacity 0.2s ease; /* Smooth hover effect */
}

.sidebar-brand:hover {
    transform: translateY(-2px); /* Subtle lift on hover */
    opacity: 0.9; /* Slight fade for interactivity */
}

.sidebar-brand img {
    width: 60px; /* Slightly smaller logo for balance */
    height: auto;
    margin-right: 12px; /* Consistent spacing */
    border-radius: 8px; /* Rounded corners for a modern look */
}

.sidebar-brand-text {
    font-family: 'Roboto', sans-serif; /* Modern, professional font */
    font-size: 22px; /* Slightly smaller for elegance */
    font-weight: 700; /* Bold but not overly heavy */
    color: #ffffff; /* High contrast white */
    text-transform: uppercase;
    letter-spacing: 1.5px; /* Slightly wider for clarity */
    line-height: 1.2; /* Improved readability */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar-brand-wrapper {
        padding: 10px 15px; /* Reduced padding for smaller screens */
    }

    .sidebar-brand img {
        width: 50px; /* Smaller logo on mobile */
    }

    .sidebar-brand-text {
        font-size: 18px; /* Smaller font on mobile */
        letter-spacing: 1px;
    }
}
</style>


<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <!-- Header Section -->
<div class="sidebar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="sidebar-brand brand-logo" href="/Web-Inventory/backend/supplier/index_suplier.php" aria-label="SIMTI Supplier Dashboard">
        <img src="/Web-Inventory/assets/images/logo.png" alt="SIMTI Logo"/>
        <span class="sidebar-brand-text">SIMTI</span>
    </a>
</div>
  
  <ul class="nav">
    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/supplier/index.php">
        <i class="mdi mdi-view-quilt menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Purchase Orders -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#pembelian" aria-expanded="false" aria-controls="pembelian">
        <i class="mdi mdi-cart menu-icon"></i>
        <span class="menu-title">Purchase Orders</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="pembelian">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/supplier/pembelian/transaksi_pembelian.php">View Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/supplier/pembelian/detail_pembelian.php">Order Details</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Delivery Schedules -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/supplier/pengiriman/data_pengiriman.php">
        <i class="mdi mdi-truck menu-icon"></i>
        <span class="menu-title">Delivery Schedules</span>
      </a>
    </li>

    <!-- Payment Status -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/supplier/pembayaran/data_pembayaran.php">
        <i class="mdi mdi-currency-usd menu-icon"></i>
        <span class="menu-title">Payment Status</span>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link text-danger" href="/Web-Inventory/proses.php?action=logout">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>