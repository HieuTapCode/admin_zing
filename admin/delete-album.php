
<?php
include('../Config/configConnectDB.php');
session_start();

  if( !isset($_SESSION['mySession']) ) {
    header('location:login.php');
}
// Kiểm tra xem biến $_GET['id'] có tồn tại không
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sử dụng prepared statement để xóa album từ cơ sở dữ liệu
    $sql = "DELETE FROM album WHERE album_id = ?";
    
    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Gắn giá trị vào truy vấn và thực thi
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Chuyển hướng người dùng trở lại trang danh sách Album
            header("Location: manage-album.php");
            exit(); // Dừng kịch bản sau khi chuyển hướng
        } else {
            // Xử lý lỗi nếu không thể thực thi truy vấn
            echo "Error deleting record: " . $stmt->error;
        }
        // Đóng truy vấn
        $stmt->close();
    } else {
        // Xử lý lỗi nếu không thể chuẩn bị truy vấn
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // Xử lý lỗi nếu không có id được cung cấp trong URL
    echo "User ID not provided.";
}

// Đóng kết nối với cơ sở dữ liệu
$conn->close();
?>