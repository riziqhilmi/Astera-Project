<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data - ASTERA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
        .header-title { 
            color: #B0B0B0; 
            font-size: 1rem; 
            font-weight: 400; 
        }
        .header-profile { 
            display: flex; 
            align-items: center; 
            gap: 1rem; 
        }
        .profile-img { 
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            object-fit: cover; 
        }
        .profile-name { 
            color: #787878; 
            font-size: 1rem; 
            font-weight: 400; 
        }
        .search-container {
            position: relative;
            width: 350px;
            margin-bottom: 2rem;
        }
        .search-bar { 
            width: 100%; 
            background: #F7F7F7; 
            border-radius: 1.5rem; 
            padding: 0.7rem 1.5rem 0.7rem 3rem; 
            font-size: 1rem; 
            color: #333; 
            border: none; 
            outline: none;
            transition: background 0.2s;
        }
        .search-bar:focus {
            background: #F0F0F0;
        }
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #B0B0B0;
            font-size: 1rem;
        }
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            background: transparent; 
            border-radius: 1rem;
            overflow: hidden;
        }
        .data-table th { 
            color: #787878; 
            font-weight: 500; 
            font-size: 1.05rem; 
            text-align: left; 
            padding: 1rem 1.5rem; 
            background: transparent; 
            border-bottom: 1px solid #F0F0F0;
        }
        .data-table td { 
            color: #787878; 
            font-size: 1rem; 
            font-weight: 400; 
            background: #fff; 
            padding: 1rem 1.5rem; 
            vertical-align: middle; 
            border-bottom: 1px solid #F3F3F3; 
        }
        .data-table tr:last-child td { 
            border-bottom: none; 
        }
        .data-table tr:hover td {
            background: #FAFAFA;
        }
        .data-table td img { 
            width: 48px; 
            height: 48px; 
            border-radius: 0.5rem; 
            object-fit: cover; 
            background: #e0e0e0; 
        }
        .status-ready { 
            background: #E6FAFD; 
            color: #2196b6; 
            font-weight: 500; 
            border-radius: 0.5rem; 
            padding: 0.3rem 1.2rem; 
            font-size: 0.9rem; 
            display: inline-block; 
        }
        .status-ilang { 
            background: #FF5C5C; 
            color: #fff; 
            font-weight: 500; 
            border-radius: 0.5rem; 
            padding: 0.3rem 1.2rem; 
            font-size: 0.9rem; 
            display: inline-block; 
        }
        .sidebar-overlay { 
            position: fixed; 
            inset: 0; 
            background: rgba(0,0,0,0.18); 
            z-index: 20; 
            display: none; 
        }
        .main-container {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Notification Styles */
        .notification-bell {
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .notification-bell:hover {
            transform: scale(1.1);
            background: #F0F0F0;
        }
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #FF5C5C;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .notification-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .notification-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .notification-header {
            padding: 1.5rem;
            border-bottom: 1px solid #F0F0F0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .notification-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        .close-notification {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background 0.2s;
        }
        .close-notification:hover {
            background: #F0F0F0;
        }
        .notification-list {
            padding: 0;
        }
        .notification-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #F0F0F0;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: background 0.2s;
        }
        .notification-item:hover {
            background: #FAFAFA;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
            flex-shrink: 0;
        }
        .notification-icon.info {
            background: #2196b6;
        }
        .notification-icon.warning {
            background: #FF9800;
        }
        .notification-icon.success {
            background: #4CAF50;
        }
        .notification-icon.error {
            background: #FF5C5C;
        }
        .notification-details {
            flex: 1;
        }
        .notification-message {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.25rem;
        }
        .notification-time {
            font-size: 0.85rem;
            color: #999;
        }
        .notification-empty {
            padding: 3rem 1.5rem;
            text-align: center;
            color: #999;
        }
        .no-results {
            text-align: center;
            padding: 3rem;
            color: #999;
            font-style: italic;
        }
        @media (max-width: 900px) {
            .main-content { padding: 1rem; }
            .sidebar { min-width: 140px; max-width: 140px; }
            .search-container { width: 100%; }
            .notification-content {
                width: 95%;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div id="app-layout" class="flex min-h-screen relative">
        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed top-0 left-0 h-full z-30 bg-white transition-transform duration-300 ease-in-out translate-x-0 w-[200px] rounded-r-2xl flex flex-col items-center pt-8" style="will-change: transform;">
            <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none md:hidden" style="font-size: 1.7rem; display: none;">
                <i class="fas fa-times"></i>
            </button>
            <div class="sidebar-logo">ASTERA</div>
            <div class="sidebar-user">User</div>
            <nav class="sidebar-menu w-full">
                <a href="#" class="sidebar-link"><i class="fas fa-th-large"></i> Dashboard</a>
                <a href="#" class="sidebar-link active"><i class="fas fa-database"></i> Data</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out ml-[200px] pt-8 px-8">
            <div class="header-bar flex items-center justify-between mb-6 pt-2 px-2">
                <button id="openSidebar" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-4 md:hidden" style="font-size: 1.7rem;">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title"></div>
                <div class="header-profile">
                    <div class="notification-bell" id="notificationBell">
                        <i class="far fa-bell" style="color:#B0B0B0; font-size:1.5rem;"></i>
                        <div class="notification-badge" id="notificationBadge">3</div>
                    </div>
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="profile-img">
                    <span class="profile-name">Hendrick Moseng (User)</span>
                </div>
            </div>
            
            <div class="main-container">
                <div class="mb-6">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input class="search-bar" type="text" id="searchInput" placeholder="Cari untuk barang, kategori, dll.">
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="data-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Stok</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr data-search="buku atk ready">
                                <td>1.</td>
                                <td><img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=facearea&w=256&q=80" alt="Buku"></td>
                                <td>Buku</td>
                                <td>ATK</td>
                                <td><span class="status-ready">Ready</span></td>
                                <td>23</td>
                                <td>Bagus</td>
                            </tr>
                            <tr data-search="keyboard atk ilang">
                                <td>2.</td>
                                <td><img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=facearea&w=256&q=80" alt="Keyboard"></td>
                                <td>Keyboard</td>
                                <td>ATK</td>
                                <td><span class="status-ilang">Ilang</span></td>
                                <td>5</td>
                                <td>Bagus</td>
                            </tr>
                            <tr data-search="laptop elektronik ready">
                                <td>3.</td>
                                <td><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=facearea&w=256&q=80" alt="Laptop"></td>
                                <td>Laptop</td>
                                <td>Elektronik</td>
                                <td><span class="status-ready">Ready</span></td>
                                <td>12</td>
                                <td>Bagus</td>
                            </tr>
                            <tr data-search="kipas elektronik ready">
                                <td>4.</td>
                                <td><img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=256&q=80" alt="Kipas"></td>
                                <td>Kipas</td>
                                <td>Elektronik</td>
                                <td><span class="status-ready">Ready</span></td>
                                <td>10</td>
                                <td>Bagus</td>
                            </tr>
                            <tr data-search="printer elektronik ready">
                                <td>5.</td>
                                <td><img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=facearea&w=256&q=80" alt="Printer"></td>
                                <td>Printer</td>
                                <td>Elektronik</td>
                                <td><span class="status-ready">Ready</span></td>
                                <td>8</td>
                                <td>Bagus</td>
                            </tr>
                            <tr data-search="komputer elektronik ready">
                                <td>6.</td>
                                <td><img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=facearea&w=256&q=80" alt="Komputer"></td>
                                <td>Komputer</td>
                                <td>Elektronik</td>
                                <td><span class="status-ready">Ready</span></td>
                                <td>25</td>
                                <td>Bagus</td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="noResults" class="no-results" style="display: none;">
                        Tidak ada hasil yang ditemukan untuk "<span id="searchTerm"></span>"
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div id="notificationModal" class="notification-modal">
        <div class="notification-content">
            <div class="notification-header">
                <div class="notification-title">Notifikasi</div>
                <button class="close-notification" id="closeNotification">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="notification-list" id="notificationList">
                <div class="notification-item">
                    <div class="notification-icon info">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="notification-details">
                        <div class="notification-message">Stok Buku telah diperbarui</div>
                        <div class="notification-time">2 menit yang lalu</div>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="notification-details">
                        <div class="notification-message">Keyboard dilaporkan hilang</div>
                        <div class="notification-time">1 jam yang lalu</div>
                    </div>
                </div>
                <div class="notification-item">
                    <div class="notification-icon success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="notification-details">
                        <div class="notification-message">Laptop telah dikembalikan</div>
                        <div class="notification-time">3 jam yang lalu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const openSidebarBtn = document.getElementById('openSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        let sidebarOpen = true;

        function setSidebar(open) {
            sidebarOpen = open;
            if (window.innerWidth < 900) {
                if (open) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebarOverlay.style.display = 'block';
                    mainContent.style.marginLeft = '0';
                    closeSidebarBtn.style.display = 'block';
                    openSidebarBtn.style.display = 'none';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarOverlay.style.display = 'none';
                    mainContent.style.marginLeft = '0';
                    closeSidebarBtn.style.display = 'none';
                    openSidebarBtn.style.display = 'block';
                }
            } else {
                if (open) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebarOverlay.style.display = 'none';
                    mainContent.style.marginLeft = '200px';
                    closeSidebarBtn.style.display = 'none';
                    openSidebarBtn.style.display = 'none';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarOverlay.style.display = 'none';
                    mainContent.style.marginLeft = '0';
                    closeSidebarBtn.style.display = 'none';
                    openSidebarBtn.style.display = 'block';
                }
            }
        }

        if(openSidebarBtn) openSidebarBtn.addEventListener('click', function() {
            setSidebar(true);
        });
        if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', function() {
            setSidebar(false);
        });
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', function() {
            setSidebar(false);
        });

        // Responsive: hide sidebar by default on small screens
        function handleResize() {
            if (window.innerWidth < 900) {
                setSidebar(false);
            } else {
                setSidebar(true);
            }
        }
        window.addEventListener('resize', handleResize);
        document.addEventListener('DOMContentLoaded', handleResize);

        // Notification functionality
        const notificationBell = document.getElementById('notificationBell');
        const notificationModal = document.getElementById('notificationModal');
        const closeNotification = document.getElementById('closeNotification');
        const notificationBadge = document.getElementById('notificationBadge');

        // Open notification modal
        notificationBell.addEventListener('click', function() {
            notificationModal.style.display = 'flex';
            // Hide badge when notifications are viewed
            notificationBadge.style.display = 'none';
        });

        // Close notification modal
        closeNotification.addEventListener('click', function() {
            notificationModal.style.display = 'none';
        });

        // Close modal when clicking outside
        notificationModal.addEventListener('click', function(e) {
            if (e.target === notificationModal) {
                notificationModal.style.display = 'none';
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && notificationModal.style.display === 'flex') {
                notificationModal.style.display = 'none';
            }
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const noResults = document.getElementById('noResults');
        const searchTerm = document.getElementById('searchTerm');
        const rows = tableBody.querySelectorAll('tr');

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.toLowerCase().trim();
            
            if (searchValue === '') {
                // Show all rows when search is empty
                rows.forEach(row => {
                    row.style.display = '';
                });
                noResults.style.display = 'none';
                return;
            }

            let hasResults = false;
            
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search').toLowerCase();
                if (searchData.includes(searchValue)) {
                    row.style.display = '';
                    hasResults = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (hasResults) {
                noResults.style.display = 'none';
            } else {
                searchTerm.textContent = searchValue;
                noResults.style.display = 'block';
            }
        });

        // Clear search when clicking on search input
        searchInput.addEventListener('click', function() {
            if (this.value === '') {
                rows.forEach(row => {
                    row.style.display = '';
                });
                noResults.style.display = 'none';
            }
        });
    </script>
</body>
</html>
