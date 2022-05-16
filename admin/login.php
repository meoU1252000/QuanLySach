<?php
ob_start();
session_start();
include_once './config.php';

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    //làm sạch thông tin, xóa bỏ các tag html, ký tự đặc biệt 
    //mà người dùng cố tình thêm vào để tấn công theo phương thức sql injection
    $username = strip_tags($username);
    $username = addslashes($username);
    $password = strip_tags($password);
    $password = addslashes($password);
    $sql = "SELECT * from staffaccount where email_staff ='$username' and password_staff=md5('$password')";
    $query=mysqli_query($conn,$sql);
    $rows=mysqli_num_rows($query);
	if($rows > 0 ){
        $row = mysqli_fetch_array($query);
        $id_staff = $row['id_staff'];
        $query_name =mysqli_query($conn,"SELECT * from staff where id_staff = '$id_staff'");
        $query_role = mysqli_query($conn,"SELECT * from roledetails where id_staff = '$id_staff'");
        $row_staff = mysqli_fetch_array($query_name);
        $_SESSION['nameStaff'] = $row_staff['name_staff'];
		$_SESSION['username'] =$username;
        $_SESSION['password'] =$password;
        $_SESSION['id_staff'] = $id_staff;
        $_SESSION['roleStaff'] = array();
        while($row_role = mysqli_fetch_array($query_role)){
            array_push($_SESSION['roleStaff'],$row_role['id_role']);
        } 
        header("location: ./index.php");
    } else {
        echo '<script language="javascript">';
        echo 'alert("Tên Đăng Nhập hoặc Mật Khẩu không đúng. Vui lòng thử lại")';
        echo '</script>';
    }
    mysqli_close($conn);
    ob_flush() ;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đăng nhập</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/fontawesome-free-5.15.3-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@100;300;400;500;700&family=Poppins:ital,wght@0,200;0,300;0,500;0,600;1,100;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="login">
            <div class="login-form">
                <h2 class = "login-form__heading">Login</h2>
                <form action="#" id="validator_login" method="POST" enctype="multipart/form-data">
                    <div class="login-form__group">
                        <label class="login-form__label" for="username">Username</label>
                        <input type="text"  id="username" name="username" class="login-form__input">
                        <span class="login-form__message"></span>
                    </div>
                    <div class="login-form__group">
                        <label class="login-form__label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="login-form__input" >
                        <span class="login-form__message"></span>
                    </div>
                    <div class="login-form__forget">
                        <a href="#">
                            Forget password ?
                        </a>
                    </div>
                    <button class="login-form__button" name="submitButton" type="submit">Login</button>
                </form>
            </div>
    </div>
    <script src="../assets/script/validator.js"></script>
    <script>
        Validator({
            form: '#validator_login',
            formGroupSelector: '.login-form__group',
            errorSelector: '.login-form__message',
            rules: [
                //Validator.isRequired('#username','<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng nhập vào tên đăng nhập của bạn'),
                Validator.isPassword('#password','<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không chính xác'),
                Validator.isEmail('#username','<i class="fas fa-exclamation-triangle warn_icon"></i>Email không chính xác')
                /*Validator.isRequired('input[name="gender"]')
                Validator.isRequired('#password','<i class="fas fa-exclamation-triangle warn_icon"></i>Vui lòng nhập vào tên đăng nhập của bạn'),
                Validator.isConfirmed('#password_confirmation', function(){
                  return document.querySelector('#validator_login #password').value;
                }),*/
            ]
        });
    </script>
</body>
</html>