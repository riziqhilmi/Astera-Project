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
        body { font-family: 'Poppins', sans-serif; background: #F3F3F3; }
        .sidebar-logo { font-size: 2rem; font-weight: 700; color: #4A8692; font-family: 'Stretch Pro', sans-serif; margin-bottom: 0.25rem; }
        .sidebar-user { color: #2196b6; font-size: 0.95rem; font-weight: 500; margin-bottom: 2.5rem; }
        .sidebar-link { display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1.5rem; color: #787878; font-size: 1.1rem; font-weight: 500; text-decoration: none; border-radius: 0.5rem; margin-bottom: 0.5rem; transition: background 0.2s, color 0.2s; }
        .sidebar-link.active, .sidebar-link:hover { background: #E6FAFD; color: #2196b6; }
        .sidebar-link i { font-size: 1.3rem; }
        .header-title { color: #B0B0B0; font-size: 1rem; font-weight: 400; }
        .header-profile { display: flex; align-items: center; gap: 1rem; }
        .profile-img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .profile-name { color: #787878; font-size: 1rem; font-weight: 400; }
        .search-bar { width: 350px; background: #F7F7F7; border-radius: 1.5rem; padding: 0.7rem 1.5rem; display: flex; align-items: center; gap: 0.7rem; font-size: 1rem; color: #B0B0B0; border: none; margin-bottom: 2rem; }
        .data-table { width: 100%; border-collapse: collapse; background: transparent; }
        .data-table th { color: #787878; font-weight: 500; font-size: 1.05rem; text-align: left; padding: 0.7rem 0.5rem 0.7rem 0; background: transparent; }
        .data-table td { color: #787878; font-size: 1rem; font-weight: 400; background: #fff; padding: 0.7rem 0.5rem 0.7rem 0; vertical-align: middle; border-bottom: 2px solid #F3F3F3; }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table td img { width: 48px; height: 48px; border-radius: 0.5rem; object-fit: cover; background: #e0e0e0; }
        .status-ready { background: #E6FAFD; color: #2196b6; font-weight: 500; border-radius: 0.5rem; padding: 0.2rem 1.1rem; font-size: 0.95rem; display: inline-block; }
        .status-ilang { background: #FF5C5C; color: #fff; font-weight: 500; border-radius: 0.5rem; padding: 0.2rem 1.1rem; font-size: 0.95rem; display: inline-block; }
        .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.18); z-index: 20; display: none; }
        @media (max-width: 900px) {
            .main-content { padding: 1rem; }
            .sidebar { min-width: 140px; max-width: 140px; }
            .search-bar { width: 100%; }
        }
    </style>
</head>
<body>
    <div id="app-layout" class="flex min-h-screen relative">
        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed top-0 left-0 h-full z-30 bg-white transition-transform duration-300 ease-in-out translate-x-0 w-[180px] rounded-r-2xl flex flex-col items-center pt-8" style="will-change: transform;">
            <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none md:hidden" style="font-size: 1.7rem; display: none;">
                <i class="fas fa-times"></i>
            </button>
            <div class="sidebar-logo">ASTERA</div>
            <div class="sidebar-user">User</div>
            <nav class="sidebar-menu w-full">
                <a href="#" class="sidebar-link"><i class="fas fa-th-large"></i> Dashboard</a>
                <a href="#" class="sidebar-link active"><i class="fas fa-th"></i> Data</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out ml-[180px] pt-12 px-10">
            <div class="header-bar flex items-center justify-between mb-8 pt-2 px-2">
                <button id="openSidebar" class="text-gray-500 hover:text-gray-700 focus:outline-none mr-4 md:hidden" style="font-size: 1.7rem;">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">UX Dashboard USER</div>
                <div class="header-profile">
                    <i class="far fa-bell" style="color:#B0B0B0; font-size:1.3rem;"></i>
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="profile-img">
                    <span class="profile-name">Hendrick Moseng (User)</span>
                </div>
            </div>
            <form style="margin-bottom:0;">
                <input class="search-bar" type="text" placeholder="&#xF002;  Cari untuk barang, kategori, dll." style="font-family: 'Poppins', 'Font Awesome 5 Free', Arial, sans-serif;">
            </form>
            <div class="overflow-x-auto">
                <table class="data-table">
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
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td><img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=facearea&w=256&q=80" alt="Buku"></td>
                            <td>Buku</td>
                            <td>ATK</td>
                            <td><span class="status-ready">Ready</span></td>
                            <td>23</td>
                            <td>Bagus</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td><img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=facearea&w=256&q=80" alt="Keyboard"></td>
                            <td>Keyboard</td>
                            <td>ATK</td>
                            <td><span class="status-ilang">Ilang</span></td>
                            <td>5</td>
                            <td>Bagus</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=facearea&w=256&q=80" alt="Laptop"></td>
                            <td>Laptop</td>
                            <td>Elektronik</td>
                            <td><span class="status-ready">Ready</span></td>
                            <td>12</td>
                            <td>Bagus</td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td><img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=256&q=80" alt="Kipas"></td>
                            <td>Kipas</td>
                            <td>Elektronik</td>
                            <td><span class="status-ready">Ready</span></td>
                            <td>10</td>
                            <td>Bagus</td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td><img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=facearea&w=256&q=80" alt="Printer"></td>
                            <td>Printer</td>
                            <td>Elektronik</td>
                            <td><span class="status-ready">Ready</span></td>
                            <td>8</td>
                            <td>Bagus</td>
                        </tr>
                        <tr>
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
                    mainContent.style.marginLeft = '180px';
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
    </script>
</body>
</html>
