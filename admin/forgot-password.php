<?php 
session_start();
include('../Config/configConnectDB.php');

if (isset($_POST['submit'])) {
    $matma = $_POST['mat_ma'];
    $email = $_POST['email'];
    $mobile = $_POST['sodienthoai'];
    $newpassword = $_POST['newpassword'];
    $confirmpassword = $_POST['confirmpassword'];

    // Kiểm tra xem mật khẩu mới và xác nhận mật khẩu có khớp không
    if ($newpassword != $confirmpassword) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!');</script>";
    } else {
        // Kiểm tra sự tồn tại của email hoặc số điện thoại
        $query = "SELECT * FROM admin WHERE (email='$email' OR sodienthoai='$mobile') AND mat_ma='$matma'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            // Cập nhật mật khẩu 
            $update_query = "UPDATE admin SET password='$newpassword' WHERE (email='$email' OR sodienthoai='$mobile') AND mat_ma='$matma'";
            if ($conn->query($update_query) === TRUE) {
                echo "<script>alert('Đổi mật khẩu thành công!');</script>";
                session_destroy();
                header("Location: login.php");
            } else {
                echo "<script>alert('Đã xảy ra lỗi, vui lòng thử lại sau.');</script>";
            }
        } else {
            echo "<script>alert('Email, số điện thoại hoặc mã khóa không tồn tại.');</script>";
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
    <title>Reset Password</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
   <script type="text/javascript">

</script>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="./images/logo.svg">
                </div>
                <h4>Quên Mật Khẩu</h4>
                <h6 class="font-weight-light">Nhập Email hoặc Số điện thoại để khôi phục mật khẩu!</h6>
                <form class="pt-3" id="login" method="post" name="login">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg"  name="mat_ma" placeholder="Nhập mã khóa" required="true" maxlength="10" pattern="[0-9]+">
                 </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required="true" >
                  </div>
                  <div class="form-group">
                    
                     <input type="text" class="form-control form-control-lg"  name="sodienthoai" placeholder="Số điện thoại" required="true" maxlength="10" pattern="[0-9]+">
                  </div>
                  <div class="form-group">
                   
                    <input class="form-control form-control-lg" type="password" name="newpassword" placeholder="Mật khẩu mới" required="true"/>
                  </div>
                  <div class="form-group">
                    
                   <input class="form-control form-control-lg" type="password" name="confirmpassword" placeholder="Xác nhận mật khẩu mới" required="true" />
                  </div>
                  
                  <div class="mt-3">
                    <button class="btn btn-success btn-block loginbtn" name="submit" type="submit"> Xác nhận </button>
                  </div>
                  <br>

                  <!-- <div class="my-2 d-flex justify-content-between align-items-center"> 
                    <a href="../admin/login.php" class="auth-link text-black"> Signin </a>
                  </div> -->

                  <br>
                  <div class="mb-2">
                    <a href="login.php" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="icon-social-home mr-2"></i> Quay Lại </a>
                  </div>
                  
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
  </body>
</html>
