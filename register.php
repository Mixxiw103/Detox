<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu nhập lại
    if ($password !== $confirm_password) {
        echo "Mật khẩu nhập lại không khớp. Vui lòng thử lại.";
    } else {
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT); // Mã hóa mật khẩu

        // Kiểm tra xem tên đăng nhập hoặc email đã tồn tại chưa
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "Tên đăng nhập hoặc email đã tồn tại. Vui lòng chọn tên đăng nhập hoặc email khác.";
        } else {
            // Chèn dữ liệu vào bảng users
            $sql = "INSERT INTO user (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_pass')";

            if ($conn->query($sql) === TRUE) {
                echo "Đăng ký thành công!";
                header("Location: login.php");
            } else {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // Đóng kết nối
    $conn->close();
}
?>