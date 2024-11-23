<?php

include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
// Khởi tạo biến
$search_name = ''; // Biến này sẽ lưu trữ giá trị của từ khóa tìm kiếm mà người dùng nhập vào
if(isset($_GET['search'])) {
  // kiểm tra search có được gửi qua phương thức GET từ URL không
    $search_name = $_GET['search']; // Nếu search tồn tại gán cho biến $search_name
}

// Lấy dữ liệu để hiển thị
$sql = "SELECT * FROM user";
if(!empty($search_name)) {
  // kiểm tra xem biến $search_name có giá trị hay không
    $sql .= " WHERE account_name LIKE '%$search_name%' OR user_name LIKE '%$search_name%' OR type_account LIKE '%$search_name%' "; // Nếu có giá trị, $sql sẽ được nối thêm (.=) điều kiện WHERE để tìm kiếm theo từ khóa
}
$result = $conn->query($sql); // Thực hiện câu truy vấn SQL được lưu trữ trong biến $sql thông qua phương thức $conn->query(). kết quả lưu vào $result

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Quản Lý Người Dùng</title>
    
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    
    <link rel="stylesheet" href="./css/style.css">
    

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
                  <li class="breadcrumb-item active" aria-current="page"> Quản lý người dùng </li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex align-items-center mb-4">
                      <h3 class="card-title mb-sm-0">Quản Lý người dùng</h3>
                      <a href="manage-user.php" class="text-blue ml-auto mb-3 mb-sm-0"> Xem tất cả người dùng</a>
                    </div>
                    <form action="" method="GET" class="mb-3">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm người dùng..." name="search" value="<?php echo $search_name; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">ID</th>
                            <th class="font-weight-bold">Tên Người Dùng</th>
                            <th class="font-weight-bold">Tên Đăng Nhập</th>
                            <th class="font-weight-bold">Loại Tài Khoản</th>
                            <th class="font-weight-bold">Thao Tác</th>

                          </tr>
                        </thead>
                        <tbody>
                        <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id_user']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['account_name']; ?></td>
                            <td><?php echo $row['type_account']; ?></td>
                            <td>
                                <a href="edit-user.php?id=<?php echo $row['id_user']; ?>" class="icon-wrench"> </a>
                                || <a href="delete-user.php?id=<?php echo $row['id_user']; ?>" onclick="return confirm('Bạn thật sự muốn xóa?'); " class="icon-trash"> </a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                      </table>
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
    
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    
    <script src="./js/dashboard.js"></script>
    
  </body>

  </html>