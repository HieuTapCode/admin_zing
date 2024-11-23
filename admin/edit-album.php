<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
$id = $_GET['id'];
$sql = "SELECT * FROM album WHERE album_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Lấy danh sách nghệ sĩ
$sql_artist = "SELECT id_user, user_name FROM user";
$result_artist = $conn->query($sql_artist);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_id = $_POST['artist_id'];
    $title_album = $_POST['title_album'];
    $name_artist = $_POST['name_artist'];
    $thumbnail_album = $_POST['thumbnail_album'];

    // Cập nhật thông tin Album vào cơ sở dữ liệu
    $sql = "UPDATE album SET artist_id=?, title_album=?, name_artist=?, thumbnail_album=? WHERE album_id=?";
    
    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Gắn giá trị vào truy vấn và thực thi
        $stmt->bind_param("isssi",$artist_id , $title_album, $name_artist, $thumbnail_album, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật thành công!');</script>";
            header("Location: manage-album.php");
            exit(); // Dừng kịch bản sau khi chuyển hướng
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

    <title>Cập Nhật Bài Hát</title>
    
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
                  <li class="breadcrumb-item active" aria-current="page"> Cập nhật Album</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thay đổi Album</h4>

                    <form class="forms-sample" method="POST">
        
                    <div class="form-group">
                            <label>ID Nghệ Sỹ</label>
                            <select name="artist_id" class="form-control" required>
                                <?php while ($artist = $result_artist->fetch_assoc()) { ?>
                                    <option value="<?php echo $artist['id_user']; ?>" 
                                        <?php echo $row['artist_id'] == $artist['id_user'] ? 'selected' : ''; ?>>
                                        <?php echo $artist['user_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tên Album</label>
                            <input type="text" name="title_album" class="form-control" value="<?php echo $row['title_album']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tên Nghệ Sỹ</label>
                            <input type="text" name="name_artist" class="form-control" value="<?php echo $row['name_artist']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail Album</label>
                            <input type="url" name="thumbnail_album" class="form-control" value="<?php echo $row['thumbnail_album']; ?>" required>
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