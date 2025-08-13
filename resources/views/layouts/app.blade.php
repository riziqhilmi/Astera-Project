<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASTERA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Notifikasi */
.notification {
    animation: slideIn 0.5s forwards, fadeOut 0.5s 4.5s forwards;
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    max-width: 350px;
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #F3F3F3; 
            margin: 0;
            padding: 0;
        }
        .sidebar-logo { 
            font-size: 2rem; 
            font-weight: 700; 
            color: #4A8692; 
            margin-bottom: 0.25rem; 
        }
        .sidebar-user { 
            color: #2196b6; 
            font-size: 0.95rem; 
            font-weight: 500; 
            margin-bottom: 2.5rem; 
        }
        .sidebar-link { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
            padding: 0.9rem 1.5rem; 
            color: #787878; 
            font-size: 1.1rem; 
            font-weight: 500; 
            text-decoration: none; 
            border-radius: 0.5rem; 
            margin-bottom: 0.5rem; 
            transition: background 0.2s, color 0.2s; 
        }
        .sidebar-link.active, .sidebar-link:hover { 
            background: #E6FAFD; 
            color: #2196b6; 
        }
        .sidebar-link i { 
            font-size: 1.3rem; 
        }
        
        /* Submenu styling */
        #dataSubMenu {
            transition: all 0.3s ease;
            max-height: 0;
            overflow: hidden;
            padding-left: 2.5rem;
        }
        
        #dataSubMenu.show {
            max-height: 500px;
        }
        
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        .transition-transform {
            transition: transform 0.3s ease;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="app-layout" class="flex min-h-screen relative">
        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-20"></div>
        
    
<aside id="sidebar" class="sidebar fixed top-0 left-0 h-full z-30 bg-white transition-transform duration-300 ease-in-out translate-x-0 w-[200px] rounded-r-2xl flex flex-col justify-between pt-8">
    <!-- Bagian Atas -->
    <div class="flex flex-col items-center w-full px-2">
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none md:hidden" style="font-size: 1.7rem;">
            <i class="fas fa-times"></i>
        </button>
        <div class="sidebar-logo">ASTERA</div>
        <div class="sidebar-user">{{ Auth::user()->name ?? 'User' }}</div>

        <nav class="sidebar-menu w-full mt-6">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    
    @if(auth()->user()->isAdmin() || auth()->user()->isUserInput())
    <!-- Data Master -->
    <div class="mb-2">
        <button id="dataMenuButton" class="sidebar-link w-full text-left {{ request()->routeIs('data_barang.*', 'data_ruangan.*') ? 'active' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-database"></i>
                    <span>Data Master</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="dataMenuIcon"></i>
            </div>
        </button>
        
        <div id="dataSubMenu" class="{{ request()->routeIs('data_barang.*', 'data_ruangan.*') ? 'show' : '' }}">
            <a href="{{ route('data_barang.index') }}" class="sidebar-link text-sm {{ request()->routeIs('data_barang.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i> Data Barang
            </a>
            <a href="{{ route('data_ruangan.index') }}" class="sidebar-link text-sm {{ request()->routeIs('data_ruangan.*') ? 'active' : '' }}">
                <i class="fas fa-door-open"></i> Data Ruangan
            </a>
        </div>
    </div>
    @endif
    
    @if(auth()->user()->isAdmin() || auth()->user()->isUserOperasional())
    <!-- Operasional -->
    <div class="mb-2">
        <button id="operasionalMenuButton" class="sidebar-link w-full text-left {{ request()->routeIs('barang_masuk.*', 'barang_keluar.*') ? 'active' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Operasional</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="operasionalMenuIcon"></i>
            </div>
        </button>
        
        <div id="operasionalSubMenu" class="{{ request()->routeIs('barang_masuk.*', 'barang_keluar.*') ? 'show' : '' }}">
            <a href="{{ route('barang_masuk.index') }}" class="sidebar-link text-sm {{ request()->routeIs('barang_masuk.*') ? 'active' : '' }}">
                <i class="fas fa-arrow-down"></i> Barang Masuk
            </a>
            <a href="{{ route('barang_keluar.index') }}" class="sidebar-link text-sm {{ request()->routeIs('barang_keluar.*') ? 'active' : '' }}">
                <i class="fas fa-arrow-up"></i> Barang Keluar
            </a>
        </div>
    </div>
    @endif
    
    @if(auth()->user()->isAdmin())
    <!-- User Management (hanya untuk admin) -->
    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> User Management
    </a>
    @endif
</nav>
    </div>

    <!-- Bagian Bawah (Logout) -->
    <div class="w-full px-2 mb-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link text-red-600 hover:text-red-800">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out ml-[200px] pt-8 px-8">
            <!-- Header Bar -->
            <div class="header-bar flex items-center justify-between mb-6 py-3 px-4 bg-white rounded-lg shadow-sm">
                <!-- Left Side - Sidebar Toggle -->
                <button id="openSidebar" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-4 md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Center - Title -->
                <div class="header-title text-gray-600 font-medium flex-1 text-center hidden md:block">
                    @yield('header-title', 'ASTERA STI PLN UID JAKARTA RAYA')
                </div>

                <!-- Right Side - Notifications and Profile -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button id="notificationBell" class="p-2 rounded-full hover:bg-gray-100 transition-colors focus:outline-none">
                            <i class="far fa-bell text-gray-500 text-xl"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                    </div>

                    <!-- Profile -->
                    <div class="flex items-center space-x-3">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                        <div class="hidden md:block">
                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">User</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="main-container">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Sidebar functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const openSidebarBtn = document.getElementById('openSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar(open) {
            if (window.innerWidth < 768) {
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                    closeSidebarBtn.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                    closeSidebarBtn.classList.add('hidden');
                }
            } else {
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    mainContent.classList.remove('ml-0');
                    mainContent.classList.add('ml-[200px]');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    mainContent.classList.add('ml-0');
                    mainContent.classList.remove('ml-[200px]');
                }
            }
        }

        openSidebarBtn.addEventListener('click', () => toggleSidebar(true));
        closeSidebarBtn.addEventListener('click', () => toggleSidebar(false));
        sidebarOverlay.addEventListener('click', () => toggleSidebar(false));

        // Handle responsive behavior
        function handleResize() {
            if (window.innerWidth >= 768) {
                toggleSidebar(true);
                sidebarOverlay.classList.add('hidden');
            } else {
                toggleSidebar(false);
            }
        }
        
        window.addEventListener('resize', handleResize);
        document.addEventListener('DOMContentLoaded', handleResize);

        // Data Menu Dropdown functionality
        const dataMenuButton = document.getElementById('dataMenuButton');
        const dataSubMenu = document.getElementById('dataSubMenu');
        const dataMenuIcon = document.getElementById('dataMenuIcon');
        
        if (dataMenuButton && dataSubMenu && dataMenuIcon) {
            dataMenuButton.addEventListener('click', function() {
                dataSubMenu.classList.toggle('show');
                dataMenuIcon.classList.toggle('rotate-180');
                
                // Close other open submenus if any
                document.querySelectorAll('.sidebar-menu > div > div').forEach(menu => {
                    if (menu !== dataSubMenu && menu.classList.contains('show')) {
                        menu.classList.remove('show');
                        menu.previousElementSibling.querySelector('i.fa-chevron-down').classList.remove('rotate-180');
                    }
                });
            });
            
            // Keep submenu open if current route matches
            if (window.location.pathname.includes('/data_barang') || 
                window.location.pathname.includes('/data_ruangan')) {
                dataSubMenu.classList.add('show');
                dataMenuIcon.classList.add('rotate-180');
            }
        }

        // Operasional Menu Dropdown functionality
const operasionalMenuButton = document.getElementById('operasionalMenuButton');
const operasionalSubMenu = document.getElementById('operasionalSubMenu');
const operasionalMenuIcon = document.getElementById('operasionalMenuIcon');

if (operasionalMenuButton && operasionalSubMenu && operasionalMenuIcon) {
    operasionalMenuButton.addEventListener('click', function() {
        operasionalSubMenu.classList.toggle('show');
        operasionalMenuIcon.classList.toggle('rotate-180');
        
        // Close other open submenus if any
        document.querySelectorAll('.sidebar-menu > div > div').forEach(menu => {
            if (menu !== operasionalSubMenu && menu.classList.contains('show')) {
                menu.classList.remove('show');
                menu.previousElementSibling.querySelector('i.fa-chevron-down').classList.remove('rotate-180');
            }
        });
    });
    
    // Keep submenu open if current route matches
    if (window.location.pathname.includes('/barang_masuk') || 
        window.location.pathname.includes('/barang_keluar')) {
        operasionalSubMenu.classList.add('show');
        operasionalMenuIcon.classList.add('rotate-180');
    }
}
    </script>

    @stack('scripts')
</body>
</html>