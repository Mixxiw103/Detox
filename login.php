<?php
// Bắt đầu phiên làm việc
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "viet";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$email = $_POST['email'];
$pass = $_POST['password'];
$fullname = $_POST['fullname'];

// Kiểm tra thông tin đăng nhập
$sql = "SELECT * FROM user WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Lấy dữ liệu người dùng
    $row = $result->fetch_assoc();
    // Kiểm tra mật khẩu
    if (password_verify($pass, $row['password'])) {
        // Đăng nhập thành công
        $_SESSION['fullname'] = $row['fullname'];
        echo "Đăng nhập thành công! Chào mừng " . $_SESSION['fullname'];
        header("location: welcome.php");
    } else {
        echo "Mật khẩu không đúng. Vui lòng thử lại.";
        
    }
} else {
    echo "Tên đăng nhập không tồn tại. Vui lòng thử lại.";
}

// Đóng kết nối
$conn->close();
?>
<a href="login.html" class="btn btn-success">Trở lại</a>
