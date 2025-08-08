@extends('layouts.app')

@section('title', 'Dashboard - ASTERA')

<<<<<<< HEAD
@section('content')
    
    
    
@endsection
=======
    /* Sidebar */
    .sidebar {
      width: 220px;
      background-color: white;
      border-right: 1px solid #eee;
      height: 100vh;
      padding: 20px 0;
    }

    .sidebar h2 {
      color: #4BA3C3;
      font-size: 20px;
      text-align: center;
      margin-bottom: 40px;
    }

    .menu {
      list-style: none;
      padding: 0;
    }

    .menu li {
      padding: 15px 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #555;
    }

    .menu li.active {
      background-color: #e6f5f8;
      border-radius: 8px;
      color: #4BA3C3;
    }

    /* Main content */
    .main {
      flex: 1;
      padding: 20px 30px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header input {
      padding: 8px 15px;
      border: 1px solid #ddd;
      border-radius: 20px;
      width: 300px;
    }

    .overview {
      margin-top: 20px;
    }

    .cards {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .card {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
    }

    .card h3 {
      margin-top: 10px;
      font-size: 18px;
    }

    .card p {
      color: gray;
      margin-top: 5px;
    }

    .charts {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }

    .chart-box {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 12px;
    }
  </style>
</head>
<body>

<div class="container">
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>ASTERA</h2>
    <ul class="menu">
      <li class="active">📊 Dashboard</li>
      <li>📁 Data Master</li>
      <li>📜 Riwayat</li>
    </ul>
  </div>

  <!-- Main content -->
  <div class="main">
    <div class="header">
      <input type="text" placeholder="Cari untuk barang, kategori, dll.">
      <div style="display: flex; align-items: center; gap: 15px;">
        <span>👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
          @csrf
          <button type="submit" style="
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
          " onmouseover="this.style.backgroundColor='#ff3742'" onmouseout="this.style.backgroundColor='#ff4757'">
            🚪 Logout
          </button>
        </form>
      </div>
    </div>

    <div class="overview">
      <h2>Overview</h2>

      <div class="cards">
        <div class="card" style="background-color: #ffeaea;">
          <h3>ATK</h3>
          <p>25 Barang</p>
        </div>
        <div class="card" style="background-color: #eaf6ff;">
          <h3>ELEKTRONIK</h3>
          <p>25 Barang</p>
        </div>
        <div class="card" style="background-color: #fffbe6;">
          <h3>PENYEWA</h3>
          <p>56 Total Penyewa</p>
        </div>
      </div>

      <div class="charts">
        <div class="chart-box">
          <canvas id="barChart"></canvas>
        </div>
        <div class="chart-box">
          <h4>PRODUK</h4>
          <canvas id="lineChart1"></canvas>
          <h4>Keluar-Masuk</h4>
          <canvas id="lineChart2"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Bar Chart
  new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des'],
      datasets: [{
        data: [10, 9, 8, 11, 7, 6, 8, 8, 8, 8, 8, 8],
        backgroundColor: '#b3d9ff'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });

  // Line Chart 1
  new Chart(document.getElementById('lineChart1'), {
    type: 'line',
    data: {
      labels: [1, 2, 3, 4, 5, 6],
      datasets: [{
        data: [20, 18, 19, 22, 25, 23],
        borderColor: 'green',
        backgroundColor: 'rgba(0,255,0,0.2)',
        fill: true
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });

  // Line Chart 2
  new Chart(document.getElementById('lineChart2'), {
    type: 'line',
    data: {
      labels: [1, 2, 3, 4, 5, 6],
      datasets: [{
        data: [10, 12, 9, 15, 35, 25],
        borderColor: 'orange',
        backgroundColor: 'rgba(255,165,0,0.3)',
        fill: true
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
  });
</script>

</body>
</html>
>>>>>>> 175d06f161274cce199eb42d8ff3889ae160288f
