<?php
    include('../Config/configConnectDB.php');
    session_start();

    if( isset($_SESSION['mySession']) ) {
      header('location:dashboard.php');
  }


  if( isset($_POST['login']) ) {
      $account_name = $_POST['account_name'];
      $password = $_POST['password'];

      $sql = "SELECT * FROM admin WHERE account_name='$account_name' and password='$password' ";

      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) == 1)
      {
          $_SESSION['mySession'] = $account_name;
          header("location:dashboard.php");
      }
      else {
          echo "<script>alert('Tài khoản hoặc mật khẩu không đúng');</script>";
      }
  }
?>

<!DOCTYPE html>
<html>
<head>
<title>Trang Quản Trị</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="css/style.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  padding: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f2f2f2;
}

form {
  border: 3px solid #f1f1f1;
  width: 100%;
  max-width: 666px;
  background-color: white;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  padding-top: 16px;
}

@media screen and (max-width: 300px) {
  span.psw {
     display: block;
  }
  
}
</style>
</head>
<body>

<div class="boxcenter">

  <form class="pt-3" action="login.php" method="post">
    <div class="imgcontainer">
      <img src="../admin/images/zingjpg.jpg" alt="Avatar" class="avatar" >
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" class="form-control form-control-lg" placeholder="Nhập tên tài khoản" name="account_name" required>

      <label><b>Password</b></label>
      <input type="password" class="form-control form-control-lg" placeholder="Nhập mật khẩu" name="password" required>
          
      <button class="btn btn-success btn-block loginbtn" type="submit" name="login">Đăng Nhập</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Lưu mật khẩu
      </label>
    </div>

    <div class="container">
      <span class="psw"><a href="forgot-password.php">Quên mật khẩu?</a></span>
    </div>
  </form>
</div>

</body>
</html>