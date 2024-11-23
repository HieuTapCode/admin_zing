<?php 
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
function getTotalRevenue() {
    global $conn;
    
    // Tạo danh sách các tháng 
    $allMonths = [
        '01' => 'Tháng 1', '02' => 'Tháng 2', '03' => 'Tháng 3', '04' => 'Tháng 4', 
        '05' => 'Tháng 5', '06' => 'Tháng 6', '07' => 'Tháng 7', '08' => 'Tháng 8', 
        '09' => 'Tháng 9', '10' => 'Tháng 10', '11' => 'Tháng 11', '12' => 'Tháng 12'
    ];

    // SQL query để lấy doanh thu theo từng tháng có dữ liệu
    $sql = "SELECT DATE_FORMAT(pay_date, '%m') AS month, SUM(amount) AS total_revenue 
            FROM payment 
            WHERE status = 'success' 
            GROUP BY month 
            ORDER BY month ASC"; 
    $result = $conn->query($sql);

    // Tạo mảng doanh thu với mặc định là 0 cho tất cả các tháng
    $revenueData = array_fill_keys(array_keys($allMonths), 0);

    // Gán doanh thu thực tế cho các tháng có dữ liệu
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $revenueData[$row['month']] = $row['total_revenue'];
        }
    }

    // Chuyển dữ liệu thành định dạng dùng cho Chart.js
    $labels = array_values($allMonths); // Lấy nhãn tháng (e.g., 'Tháng 1', 'Tháng 2')
    $revenueCounts = array_values($revenueData); // Doanh thu tương ứng với mỗi tháng

    return [
        'labels' => $labels,
        'revenueCounts' => $revenueCounts
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <title>Quản lý doanh thu</title>
    
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="container-scroller">

        <?php include_once('includes/header.php'); ?>

        <div class="container-fluid page-body-wrapper">
            
            <?php include_once('includes/sidebar.php'); ?>
            
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-sm-flex align-items-baseline report-summary-header">
                                                <h5 class="font-weight-semibold">Quản Lý Thống Kê</h5> 
                                                <span class="ml-auto">Làm mới thống kê</span> 
                                                <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row report-inner-cards-wrapper">
                                        <div class="col-md-6">
                                            <canvas id="revenueChart"></canvas>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    
    <script>
        // Dữ liệu tổng doanh thu 
        var totalRevenueData = <?php echo json_encode(getTotalRevenue()); ?>;

        // Tạo biểu đồ doanh thu bằng Chart.js
        var revenueChart = new Chart(document.getElementById('revenueChart'), { 
            type: 'bar',
            data: {
                labels: totalRevenueData.labels, // Nhãn là các tháng (e.g., '2024-01', '2024-02')
                datasets: [{
                    label: 'Tổng doanh thu (VND)',
                    data: totalRevenueData.revenueCounts, // Tổng doanh thu cho mỗi tháng
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền cột
                    borderColor: 'rgba(75, 192, 192, 1)', // Màu viền cột
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Trục Y bắt đầu từ 0
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Biểu đồ thống kê doanh thu theo tháng'
                    }
                }
            }
        });
    </script>

    <script src="vendors/js/vendor.bundle.base.js"></script>
    
</body>

</html>