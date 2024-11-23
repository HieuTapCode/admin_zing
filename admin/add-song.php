<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Lấy dữ liệu từ form
  
  $album_id = $_POST['album_id'];
  $artist_id = $_POST['artist_id'];
  $title_artist = $_POST['title_artist'];
  $title_song = $_POST['title_song'];
  $song_thumbnail = $_POST['song_thumbnail'];
  $mp3_link = $_POST['mp3_link'];
  $release_date = $_POST['release_date'];
  $type_song = $_POST['type_song'];
  $kindof = $_POST['kindof'];

  // Kiểm tra xem title_song đã tồn tại chưa
  $check_query = "SELECT * FROM song WHERE title_song = ?";
  $stmt = $conn->prepare($check_query);
  $stmt->bind_param("s", $title_song);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      echo "<script>alert('Tên bài hát đã tồn tại!');</script>";
  } else {
      // Thêm bài hát mới vào cơ sở dữ liệu
      $insert_query = "INSERT INTO song (album_id, artist_id, title_artist, title_song, song_thumbnail, mp3_link, release_date, type_song, kindof) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($insert_query);
      $stmt->bind_param("iisssssss",  $album_id, $artist_id, $title_artist, $title_song, $song_thumbnail, $mp3_link, $release_date, $type_song, $kindof);

      if ($stmt->execute()) {
          // Thêm thành công
          echo "<script>alert('Thêm mới bài hát thành công!');</script>";
          header('Location: manage-song.php'); // Chuyển hướng về trang danh sách bài hát
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

    <title>Thêm Bài Hát</title>
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
                  <li class="breadcrumb-item active" aria-current="page"> Thêm bài hát mới</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thêm bài hát mới</h4>

                    <form method="POST" action="">
                    
                      <div class="form-group">
                          <label>ID Album</label>
                          <select name="album_id" id="album_id" class="form-control" required>
                            <option value="">Chọn Album</option>
                            <?php
                            // Truy vấn danh sách album từ cơ sở dữ liệu
                            $album_query = "SELECT album_id, title_album FROM album";
                            $album_result = $conn->query($album_query);
                            
                            while ($album_row = $album_result->fetch_assoc()) {
                              echo '<option value="'.$album_row['album_id'].'">'.$album_row['title_album'].'</option>';
                            }
                            ?>
                          </select>
                      </div>

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
                          <label>Tên nghệ sỹ</label>
                          <input type="text" name="title_artist" id="title_artist" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Tên bài hát</label>
                          <input type="text" name="title_song" id="title_song" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Thumbnail Song</label>
                          <input type="url" name="song_thumbnail" id="song_thumbnail" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Link MP3</label>
                          <input type="url" name="mp3_link" id="mp3_link" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Ngày phát hành</label>
                          <input type="datetime-local" name="release_date" id="release_date" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Loại nhạc</label>
                          <input type="text" name="type_song" id="type_song" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label>Thể loại</label>
                          <input type="text" name="kindof" id="kindof" class="form-control" required>
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