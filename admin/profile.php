<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
// Giả sử bạn có `id_user` của admin cần hiển thị
$id_user = 1; // Thay thế bằng id_user thực tế

// Kiểm tra xem form đã được submit chưa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $matma = $_POST['mat_ma'];
    $user_name = $_POST['user_name'];
    $account_name = $_POST['account_name'];
    $email = $_POST['email'];
    $sodienthoai = $_POST['sodienthoai'];

    // Thực hiện cập nhật thông tin admin vào cơ sở dữ liệu
    $sql_update = "UPDATE admin SET mat_ma=?, user_name=?, account_name=?, email=?, sodienthoai=? WHERE id_user=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi",$matma , $user_name, $account_name, $email, $sodienthoai, $id_user);

    if ($stmt_update->execute()) {
        echo "<script>alert('Cập nhật thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật thông tin!');</script>" . $conn->error;
    }

    $stmt_update->close();
}

// Truy vấn để lấy thông tin của admin từ bảng
$sql = "SELECT * FROM admin WHERE id_user=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Kiểm tra xem có dữ liệu không
if (!$row) {
    echo "Không tìm thấy dữ liệu";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thông tin cá nhân</title>
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
                                <li class="breadcrumb-item active" aria-current="page"> Thông tin cá nhân </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Quản lý thông tin cá nhân</h4>

                                    <form class="forms-sample" method="POST" action="">
                                        <div class="form-group">
                                          <label>Mã khóa</label>
                                          <input type="text" name="mat_ma" class="form-control" value="<?php echo $row['mat_ma']; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Tên Quản Trị</label>
                                          <input type="text" name="user_name" class="form-control" value="<?php echo $row['user_name']; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Tên Đăng Nhập</label>
                                          <input type="text" name="account_name" class="form-control" value="<?php echo $row['account_name']; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Email</label>
                                          <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                      </div>
                                      <div class="form-group">
                                          <label>Số điện thoại</label>
                                          <input type="text" name="sodienthoai" class="form-control" value="<?php echo $row['sodienthoai']; ?>" required>
                                      </div>

                                      <button type="submit" class="btn btn-primary">Cập nhật</button>
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
