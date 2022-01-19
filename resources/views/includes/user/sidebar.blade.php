    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
          <div class="sidebar-brand-text mx-3">
              Opentrip </div>  
                  
        </a>
        
        <!-- Divider -->
        <hr class="sidebar-divider">
  
        <!-- Heading -->
        <div class="sidebar-heading">
          Statistik Dashboard
        </div>
        
        {{-- Dashboard --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.dashboard') }}">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>Dashboard</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
         <!-- Heading -->
         <div class="sidebar-heading">
           Transaksi
         </div>
         
         {{-- Transaksi --}}
         <li class="nav-item">
             <a class="nav-link" href="{{ route('user.dashboard-history') }}">
               <i class="fas fa-fw fa-dollar-sign"></i>
               <span>History Transaksi</span></a>
         </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        {{-- Transaksi --}}
         <li class="nav-item">
             <a class="nav-link" href="{{ route('user.profile') }}">
               <i class="fas fa-cog"></i>
               <span>Setting Account</span></a>
         </li>

        <!-- Divider -->
        <hr class="sidebar-divider">
 
  
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
  
      </ul>
      <!-- End of Sidebar -->