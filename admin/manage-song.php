<?php

include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
// Khởi tạo biến
$search_name = '';
if(isset($_GET['search'])) {
    $search_name = $_GET['search'];
}

// Lấy dữ liệu để hiển thị
$sql = "SELECT * FROM song";
if(!empty($search_name)) {
    $sql .= " WHERE title_song LIKE '%$search_name%' OR title_artist LIKE '%$search_name%' OR type_song LIKE '%$search_name%'";
}
$result = $conn->query($sql);
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>

    <title>Quản Lý Bài Hát</title>
    
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
                  <li class="breadcrumb-item active" aria-current="page"> Quản lý bài hát</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex align-items-center mb-4">
                      <h3 class="card-title mb-sm-0">Quản Lý Bài Hát</h3>
                      <a href="manage-song.php" class="text-blue ml-auto mb-3 mb-sm-0"> Xem tất cả bài hát</a>
                    </div>
                    <form action="" method="GET" class="mb-3">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm bài hát..." name="search" value="<?php echo $search_name; ?>">
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
                            <th class="font-weight-bold">Tên nghệ sỹ</th>
                            <th class="font-weight-bold">Tên bài hát</th>
                            <th class="font-weight-bold">Thumbnail Song</th>
                            <th class="font-weight-bold">Link MP3</th>
                            <th class="font-weight-bold">Ngày phát hành</th>
                            <th class="font-weight-bold">Thời lượng</th>
                            <th class="font-weight-bold">Số lượt nghe</th>
                            <th class="font-weight-bold">Loại nhạc</th>
                            <th class="font-weight-bold">Thể loại</th>
                            <th class="font-weight-bold">Thao tác</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['song_id']; ?></td>
                                <td><?php echo $row['title_artist']; ?></td>
                                <td><?php echo $row['title_song']; ?></td>
                                <td><?php echo $row['song_thumbnail']; ?></td>
                                <td><?php echo $row['mp3_link']; ?></td>
                                <td><?php echo $row['release_date']; ?></td>
                                <td><?php echo $row['duration']; ?></td>
                                <td><?php echo $row['listen_count']; ?></td>
                                <td><?php echo $row['type_song']; ?></td>
                                <td><?php echo $row['kindof']; ?></td>
                                <td>
                                    <a href="edit-song.php?id=<?php echo $row['song_id']; ?>" class="icon-wrench"> </a>
                                    || <a href="delete-song.php?id=<?php echo $row['song_id']; ?>" onclick="return confirm('Bạn thật sự muốn xóa?'); " class="icon-trash"> </a>
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