<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
// Giả sử bạn có `id_user` của admin đang đăng nhập
$id_user = 1; // Thay thế bằng id_user thực tế

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_password = $_POST['old_password']; // Mật khẩu cũ
    $new_password = $_POST['new_password']; // Mật khẩu mới
    // $confirm_password = $_POST['confirm_password']; // Xác nhận mật khẩu mới

    // Truy vấn lấy mật khẩu cũ từ cơ sở dữ liệu
    $sql = "SELECT password FROM admin WHERE id_user=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Kiểm tra xem mật khẩu cũ có đúng không
    if ($row && $row['password'] == $old_password) { 
        // Mật khẩu cũ đúng, cập nhật mật khẩu mới
        $sql_update = "UPDATE admin SET password=? WHERE id_user=?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $new_password, $id_user);

        if ($stmt_update->execute()) {
            //echo "Mật khẩu đã được đổi thành công!";
        } else {
            echo "<script>alert('Lỗi khi đổi mật khẩu!');</script>" . $stmt_update->error;;
        }

        $stmt_update->close();
    } else {
        echo "<script>alert('Mật khẩu cũ không đúng!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đổi mật khẩu</title>
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
                    <div class="page-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Đổi mật khẩu </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Đổi mật khẩu</h4>

                                    <form class="forms-sample" method="POST" action="">
                                        <div class="form-group">
                                            <label>Mật khẩu cũ</label>
                                            <input type="password" name="old_password" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Mật khẩu mới</label>
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div>
                                        <!-- <div class="form-group">
                                            <label>Xác nhận mật khẩu mới</label>
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div> -->
                                        
                                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    </form>
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
