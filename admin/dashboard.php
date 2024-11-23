<?php
  include('../Config/configConnectDB.php');
  session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Manage Zingmusic</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                          <h4 class="font-weight-semibold">Trang Quản Lý</h4> <span class="ml-auto">Làm mới thống kê</span> <a href="dashboard.php" class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                      <div class=" col-md -6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <?php
                          // Đếm tổng số album
                          $sql_count = "SELECT COUNT(*) AS total_albums FROM album";
                          $count_result = $conn->query($sql_count);
                          $total_albums = 0;
                          if ($count_result->num_rows > 0) {
                              $row = $count_result->fetch_assoc();
                              $total_albums = $row['total_albums'];
                          }
                          ?>
                          <span class="report-title">Tổng số Album</span>
                          <h4><?php echo htmlentities($total_albums); ?></h4>
                          <a href="manage-album.php"><span class="report-count">Xem tất cả Album</span></a>
                        </div>

                        <div class="inner-card-icon bg-success">
                          <i class="icon-notebook"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <?php
                          // Đếm tổng số người dùng
                            $sql_count = "SELECT COUNT(*) AS total_users FROM user";
                            $count_result = $conn->query($sql_count);
                            $total_users = 0;
                            if ($count_result->num_rows > 0) {
                                $row = $count_result->fetch_assoc();
                                $total_users = $row['total_users'];
                            }

                          ?>
                          <span class="report-title">Tổng số người dùng</span>
                          <h4><?php echo htmlentities($total_users); ?></h4>
                          <a href="manage-user.php"><span class="report-count">Xem tất cả Người Dùng</span></a>
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-people"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <?php
                          // Đếm tổng số bài hát
                          $sql_count = "SELECT COUNT(*) AS total_songs FROM song";
                          $count_result = $conn->query($sql_count);
                          $total_songs = 0;
                          if ($count_result->num_rows > 0) {
                              $row = $count_result->fetch_assoc();
                              $total_songs = $row['total_songs'];
                          }
                          ?>
                          <span class="report-title">Tổng số Bài Hát</span>
                          <h4><?php echo htmlentities($total_songs); ?></h4>
                          <a href="manage-song.php"><span class="report-count">Xem tất cả Bài Hát</span></a>
                        </div>

                        <div class="inner-card-icon bg-warning">
                          <i class="icon-doc"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                          <?php
                            // Tính tổng doanh thu
                            $sql_total_revenue = "SELECT SUM(amount) AS total_revenue FROM payment";
                            $revenue_result = $conn->query($sql_total_revenue);
                            $total_revenue = 0;
                            if ($revenue_result->num_rows > 0) {
                                $row = $revenue_result->fetch_assoc();
                                $total_revenue = $row['total_revenue'];
                            }
                          ?>
                            <span class="report-title">Tổng Doanh Thu</span>
                            <h4><?php echo htmlentities(number_format($total_revenue, 0, ',', '.')) . ' VND'; ?></h4>
                            <a href="payment.php"><span class="report-count">Xem chi tiết</span></a>
                        </div>

                        <div class="inner-card-icon bg-primary">
                          <i class="icon-wallet"></i>
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
    </div>
    
    <script src="vendors/js/vendor.bundle.base.js"></script>
    
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/moment/moment.min.js"></script>
    <script src="vendors/daterangepicker/daterangepicker.js"></script>
    <script src="vendors/chartist/chartist.min.js"></script>
    
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    
    <script src="js/dashboard.js"></script>
    
  </body>

  </html>