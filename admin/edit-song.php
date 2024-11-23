<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
$id = $_GET['id'];
$sql = "SELECT * FROM song WHERE song_id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Lấy danh sách album
$sql_album = "SELECT album_id, title_album FROM album";
$result_album = $conn->query($sql_album);

// Lấy danh sách nghệ sĩ
$sql_artist = "SELECT id_user, user_name FROM user";
$result_artist = $conn->query($sql_artist);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $album_id = $_POST['album_id'];
    $artist_id = $_POST['artist_id'];
    $title_artist = $_POST['title_artist'];
    $title_song = $_POST['title_song'];
    $song_thumbnail = $_POST['song_thumbnail'];
    $mp3_link = $_POST['mp3_link'];
    $release_date = $_POST['release_date'];
    $type_song = $_POST['type_song'];
    $kindof = $_POST['kindof'];

    // Cập nhật thông tin bài hát vào cơ sở dữ liệu
    $sql = "UPDATE song SET album_id=?, artist_id=?, title_artist=?, title_song=?, song_thumbnail=?, mp3_link=?, release_date=?, type_song=?, kindof=? WHERE song_id=?";
    
    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Gắn giá trị vào truy vấn và thực thi
        $stmt->bind_param("iisssssssi",  $album_id, $artist_id, $title_artist, $title_song, $song_thumbnail, $mp3_link, $release_date, $type_song, $kindof, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật thành công!');</script>";
            header("Location: manage-song.php");
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
                  <li class="breadcrumb-item active" aria-current="page"> Cập nhật bài hát</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thay đổi bài hát</h4>

                    <form class="forms-sample" method="POST">

                        <div class="form-group">
                          <label>ID Album</label>
                          <select name="album_id" class="form-control" required>
                              <?php while ($album = $result_album->fetch_assoc()) { ?>
                                  <option value="<?php echo $album['album_id']; ?>" 
                                      <?php echo $row['album_id'] == $album['album_id'] ? 'selected' : ''; ?>>
                                      <?php echo $album['title_album']; ?>
                                  </option>
                              <?php } ?>
                          </select>
                        </div>

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
                            <label>Tên nghệ sỹ</label>
                            <input type="text" name="title_artist" class="form-control" value="<?php echo $row['title_artist']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tên bài hát</label>
                            <input type="text" name="title_song" class="form-control" value="<?php echo $row['title_song']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail Song</label>
                            <input type="url" name="song_thumbnail" class="form-control" value="<?php echo $row['song_thumbnail']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Link MP3</label>
                            <input type="url" name="mp3_link" class="form-control" value="<?php echo $row['mp3_link']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Ngày phát hành</label>
                            <input type="datetime-local" name="release_date" class="form-control" value="<?php echo $row['release_date']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Loại nhạc</label>
                            <select name="type_song" class="form-control">
                                <option value="free" <?php echo $row['type_song'] == 'free' ? 'selected' : ''; ?>>Free</option>
                                <option value="vip" <?php echo $row['type_song'] == 'vip' ? 'selected' : ''; ?>>Vip</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thể loại</label>
                            <input type="text" name="kindof" class="form-control" value="<?php echo $row['kindof']; ?>" required>
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