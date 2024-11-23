<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
$id = $_GET['id']; // Lấy giá trị id từ URL qua phương thức GET
$sql = "SELECT * FROM user WHERE id_user=$id";
$result = $conn->query($sql); // Thực thi câu truy vấn SQL và lưu kết quả trả về biến $result
$row = $result->fetch_assoc(); // lấy dữ liệu từ $result và chuyển nó thành một mảng kết hợp lưu trong $row


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // khi người dùng gửi dữ liệu từ một form (dưới dạng POST), mã bên trong khối if này sẽ được thực thi   
    $account_name = $_POST['account_name'];
    $user_name = $_POST['user_name'];
    $type_account = $_POST['type_account'];
    $password = $_POST['password'];

    // Tạo câu truy vấn SQL UPDATE để thay đổi thông tin người dùng trong bảng user với điều kiện id_user bằng $id
    $sql = "UPDATE user SET account_name=?, user_name=?, type_account=?, password=? WHERE id_user=?";
    
    // Chuẩn bị câu truy vấn bằng phương thức prepare() giúp ngăn chặn tấn công SQL Injection
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Gắn giá trị vào truy vấn và thực thi
        $stmt->bind_param("ssssi", $account_name, $user_name, $type_account, $password, $id);
        if ($stmt->execute()) {
          // Thực thi câu truy vấn đã chuẩn bị với các giá trị đã gắn. Nếu thành công, khối bên được thực thi
            echo "<script>alert('Cập nhật thành công!');</script>";
            header("Location: manage-user.php");
            exit(); 
        } else {
            echo "Lỗi cập nhật bản ghi: " . $stmt->error;
        }
        // Đóng truy vấn
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị truy vấn: " . $conn->error;
    }
} 

$conn->close();
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Cập nhật sinh viên</title>
    
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
                  <li class="breadcrumb-item active" aria-current="page"> Cập nhật User</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Cập nhật User</h4>

                    <form class="forms-sample" method="POST">
                        <div class="form-group">
                            <label>Tên Đăng Nhập</label>
                            <input type="text" name="account_name" class="form-control" value="<?php echo $row['account_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tên Người Dùng</label>
                            <input type="text" name="user_name" class="form-control" value="<?php echo $row['user_name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo $row['password']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Loại Tài Khoản</label>
                            <select name="type_account" class="form-control">
                                <option value="free" <?php echo $row['type_account'] == 'free' ? 'selected' : ''; ?>>Free</option>
                                <option value="vip" <?php echo $row['type_account'] == 'vip' ? 'selected' : ''; ?>>Vip</option>
                            </select>
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
    
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    
  </body>

  </html>