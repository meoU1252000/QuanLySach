<?php 
session_start();
include_once '../admin/config.php';

if(isset($_POST['username_login']) && isset($_POST['password_login'])){
    $username = $_POST['username_login'];
    $password = $_POST['password_login'];
    //làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
    //mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
    $username = strip_tags($username);
    $username = addslashes($username);
    $password = strip_tags($password);
    $password = addslashes($password);
    $check = mysqli_query($conn,"SELECT * from customers WHERE username_customer = '$username' AND password_customer = md5('$password')");
    $checkadmin = mysqli_query($conn,"SELECT * from staffaccount WHERE email_staff = '$username' and password_staff = md5('$password')");
    if(mysqli_num_rows($check) > 0 ){
        $row = mysqli_fetch_array($check);
        $id_customer = $row['id_customer'];
        $_SESSION['id_customer'] = $id_customer;
        $_SESSION['title'] = "Đăng Nhập Thành Công!";
        $_SESSION['icon']= "success";
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    }else if(mysqli_num_rows($checkadmin) > 0 ){
        $row = mysqli_fetch_array($checkadmin);
        $id_staff = $row['id_staff'];
        $_SESSION['idStaff'] = $id_staff;
        $_SESSION['title'] = "Đăng Nhập Thành Công!";
        $_SESSION['icon']= "success";
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    }else{
        $_SESSION['title'] = "Đăng Nhập Thất Bại !";
        $_SESSION['text'] = "Tài khoản không tồn tại! Vui lòng đăng ký tài khoản";
        $_SESSION['icon']= "error";
        // echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
        $conn -> rollback();
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    };
    mysqli_close($conn);
};
?>
