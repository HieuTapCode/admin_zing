<?php

include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Lấy dữ liệu từ form
  $account_name = $_POST['account_name'];
  $user_name = $_POST['user_name'];
  //$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
  $password = $_POST['password'];
  $avatar_link = $_POST['avatar_link'];
  $type_account = $_POST['type_account'];

  // Kiểm tra xem account_name hoặc username đã tồn tại chưa. Dấu ? để sử dụng sau với câu lệnh bind_param
  $check_query = "SELECT * FROM user WHERE account_name = ? OR user_name = ?";
  $stmt = $conn->prepare($check_query); // câu truy vấn $check_query sử dụng phương thức prepare() từ đối tượng kết nối csdl $conn
  $stmt->bind_param("ss", $account_name, $user_name); // gắn giá trị của biến vào hai dấu ? trong câu truy vấn $check_query
  $stmt->execute(); // thực thi câu truy vấn đã chuẩn bị và lấy kết quả trả về
  $result = $stmt->get_result(); // lấy kết quả từ việc thực thi truy vấn dưới dạng một đối tượng kết quả $result

  if ($result->num_rows > 0) { 
      // Kiểm tra nếu số hàng trong kết quả lớn hơn 0
      echo "<script>alert('account_name hoặc Tên đăng nhập đã tồn tại!');</script>";
  } else {
      // Thêm người dùng mới vào cơ sở dữ liệu
      $insert_query = "INSERT INTO user (account_name, user_name, password, avatar_link, type_account) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_query); // câu truy vấn $insert_query bằng phương thức prepare()
      $stmt->bind_param("sssss", $account_name, $user_name, $password, $avatar_link, $type_account); // Gắn các giá trị từ biến vào các dấu ? trong câu truy vấn INSERT

      if ($stmt->execute()) {
          // Thực thi câu truy vấn để thêm người dùng mới vào cơ sở dữ liệu. Nếu thành công, phần bên trong khối if sẽ được thực hiện.
          echo "<script>alert('Thêm mới người dùng thành công!');</script>";
          header('Location: manage-user.php'); // Chuyển hướng về trang danh sách người dùng
          exit();
      } else {
          // Thêm thất bại
          echo "<script>alert('Đã có lỗi xảy ra. Vui lòng thử lại!');</script>";
      }
  }
}
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Thêm người dùng</title>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    
    <link rel="stylesheet" href="css/style.css" />

  </head>

  <body>
    <div class="container-scroller">
      
      
      <div class="container-fluid page-body-wrapper">
        
        <?php include_once('includes/sidebar.php'); ?>
        
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Trang chủ</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Thêm người dùng</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thêm người dùng</h4>

                    <form method="POST" action="">
                      <div class="form-group">
                          <label>Tên Người Dùng</label>
                          <input type="text" name="account_name" id="account_name" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Tên Đăng Nhập</label>
                          <input type="text" name="user_name" id="user_name" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Mật Khẩu</label>
                          <input type="password" name="password" id="password" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Ảnh đại diện</label>
                          <input type="file" name="avatar_link" id="avatar_link" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>Loại Tài Khoản</label>
                          <select name="type_account" id="type_account" class="form-control" required>
                              <option value="free">Free</option>
                              <option value="vip">Vip</option>
                          </select>
                      </div>
                      
                      <button type="submit" class="btn btn-primary">Thêm</button>
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
    
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    
  </body>

  </html>