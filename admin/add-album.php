<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Lấy dữ liệu từ form
  $artist_id = $_POST['artist_id'];
  $title_album = $_POST['title_album'];
  $name_artist = $_POST['name_artist'];
  $thumbnail_album = $_POST['thumbnail_album'];

  // Kiểm tra xem title_album đã tồn tại chưa
  $check_query = "SELECT * FROM album WHERE title_album = ?";
  $stmt = $conn->prepare($check_query);
  $stmt->bind_param("s", $title_album);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      // Album đã tồn tại
      echo "<script>alert('Tên Album đã tồn tại!');</script>";
  } else {
      // Thêm Album mới vào cơ sở dữ liệu
      $insert_query = "INSERT INTO album (artist_id, title_album, name_artist, thumbnail_album) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_query);
      $stmt->bind_param("isss", $artist_id, $title_album, $name_artist, $thumbnail_album);

      if ($stmt->execute()) {
          // Thêm thành công
          echo "<script>alert('Thêm mới Album thành công!');</script>";
          header('Location: manage-album.php'); // Chuyển hướng về trang danh sách album
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

    <title>Thêm Album </title>
    
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
                  <li class="breadcrumb-item active" aria-current="page"> Thêm album</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;"> Thêm Album</h4>

                    <form method="POST" action="">
            
                    <div class="form-group">
                        <label>ID Nghệ Sỹ</label>
                        <select name="artist_id" id="artist_id" class="form-control" required>
                          <option value="">Chọn Nghệ Sỹ</option>
                          <?php
                          // Truy vấn danh sách nghệ sĩ từ bảng user
                          $artist_query = "SELECT id_user, user_name FROM user"; 
                          $artist_result = $conn->query($artist_query);
                          
                          while ($artist_row = $artist_result->fetch_assoc()) {
                            echo '<option value="'.$artist_row['id_user'].'">'.$artist_row['user_name'].'</option>';
                          }
                          ?>
                        </select>
                      </div>
                      
                      <div class="form-group">
                          <label>Tên Album</label>
                          <input type="text" name="title_album" id="title_album" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Tên Nghệ Sỹ</label>
                          <input type="text" name="name_artist" id="name_artist" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Thumbnail Album</label>
                          <input type="url" name="thumbnail_album" id="thumbnail_album" class="form-control" required>
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