
<?php 
session_start();
include_once '../admin/config.php';

   if(isset($_POST['new-email']) && isset($_POST['new-username']) && isset($_POST['new-password'])){
       $email = $_POST['new-email'];
       $username = $_POST['new-username'];
       $password = $_POST['new-password'];
       $check = mysqli_query($conn,"SELECT * FROM customers where username_customer = '$username' or email_customer = '$email'");
       if(mysqli_num_rows($check) > 0){
            $_SESSION['title'] = "Đăng Ký Thất Bại !";
            $_SESSION['text'] = "Tài khoản đã tồn tại";
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
       }else{
           if(mysqli_query($conn,"INSERT into customers(email_customer,username_customer,password_customer) value ('$email','$username',md5('$password'))")){
                 $_SESSION['title'] = "Đăng Ký Thành Công!";
                 $_SESSION['icon']= "success";
                 $url = "index.php";
                 if(headers_sent()){
                     die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                 }else{
                      header ("location: $url");
                      die();
                 }
           }
        //    else{
        //     //    echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
        //    }
           
       }
       mysqli_close($conn);
   }
?>
