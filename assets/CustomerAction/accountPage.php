<?php 
include_once '../admin/config.php';

if(isset($_SESSION['id_customer'])){
$id_customer = $_SESSION['id_customer'];
$sql = "SELECT * FROM customers WHERE id_customer = '$id_customer'";
$query = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($query);
if(isset($_POST['name_customer']) && isset($_POST['phone_customer']) && $_POST['email_customer']){
    $name = $_POST['name_customer'];
    $phone_customer = $_POST['phone_customer'];
    $email = $_POST['email_customer'];
    if($_POST['new_password'] != ''){
        $old_password = $_POST['old_password'];
        $check = mysqli_query($conn, "SELECT * FROM customers where password_customer = md5('$old_password') and id_customer = '$id_customer'");
        
        if(mysqli_num_rows($check) > 0){
            $password_customer = $_POST['new_password'];
            $update = "UPDATE customers SET name_customer = '$name', phone_customer = '$phone_customer', email_customer = '$email', password_customer = md5('$password_customer') where id_customer = '$id_customer'";
        }else{
            $_SESSION['title'] = "Thay Đổi Thông Tin Thất Bại !";
            $_SESSION['text'] = "Sai Mật Khẩu. Vui Lòng Thử Lại!";
            $_SESSION['icon']= "error";
            //  echo "Lỗi. Vui lòng thử lại " . $check . "<br>" . mysqli_error($conn);
            $conn -> rollback();
            $url = "index.php?page_layout=accountPage";
            if(headers_sent()){
                die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                 header ("location: $url");
                 die();
            }
        }
    }else{
        $update = "UPDATE customers SET name_customer = '$name', phone_customer = '$phone_customer', email_customer = '$email' where id_customer = '$id_customer'";
    }
    if(mysqli_query($conn,$update)){
        $_SESSION['title'] = "Thay Đổi Thông Tin Thành Công!";
        $_SESSION['icon']= "success";
        $url = "index.php?page_layout=accountPage";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    }else{
        $_SESSION['title'] = "Thay Đổi Thông Tin Thất Bại !";
        $_SESSION['icon']= "error";
        //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
        $conn -> rollback();
        $url = "index.php?page_layout=accountPage";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    }
}
}else{
    $_SESSION['title'] = "Truy Cập Thất Bại !";
    $_SESSION['icon']= "error";
    $_SESSION['text']= "Vui lòng đăng nhập để truy cập trang này";
    //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
    $conn -> rollback();
    $url = "index.php";
    if(headers_sent()){
        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
    }else{
         header ("location: $url");
         die();
    }
}
?>


<style>
    .slider_section {
        display:none;
    }

</style>

<section class="body_section layout_padding" style="margin-top:36px">
    <div class="container">
        <div class="row header_page">
          <h4>Thông Tin Tài Khoản</h4>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id = "validatorAccountPage">
            <div class="row">
                 <div class="col-md-6">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Họ Và Tên</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào họ tên của bạn" name="name_customer" id="nameCus"  value="<?php 
                            if($row['name_customer'] !== ""){
                                echo $row['name_customer'];
                            }else{
                                echo "";
                            }
                         ?>">
                         <span class="form-group__message"></span>
                    </div>
                 </div>
    
                 <div class="col-md-6">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Số Điện Thoại</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào số điện thoại của bạn" name="phone_customer" id="phoneCus" 
                         value="<?php 
                            if($row['phone_customer'] !== ""){
                                echo $row['phone_customer'];
                            }else{
                                echo "";
                            }
                         ?>">
                          <span class="form-group__message"></span>
                    </div>
                </div>
            </div>
       
        
      
            <div class="row">
                 <div class="col-md-12">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Địa Chỉ Email</label>
                         <input type="email" class="form-control"  placeholder="Nhập vào địa chỉ Email của bạn" name="email_customer" id="emailCus" value="<?php echo $row['email_customer'];?>">
                         <span class="form-group__message"></span>
                    </div>
                 </div>

            </div>
       
             <div class="row">
                <div class="col-md-12">
                     <div class="row--content">
                         <div class="row--seperate">
                             <span>THAY ĐỔI MẬT KHẨU</span>
                         </div>
                    </div>
               </div>
            </div>

             
             <div class="row">
                   <div class="col-md-12">
                      <div class="mb-3">
                           <label for="exampleFormControlInput1" class="form-label">Mật Khẩu Hiện Tại</label>
                           <input type="password" class="form-control"  placeholder="Nhập vào mật khẩu hiện tại của bạn" name="old_password" id="oldPassword" >
                            <span class="form-group__message"></span>
                      </div>
                   </div>
      
              </div>
       
        
            <div class="row">
                 <div class="col-md-12">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Mật Khẩu Mới</label>
                         <input type="password" class="form-control" placeholder="Nhập vào mật khẩu bạn muốn thay đổi" name="new_password" id="newPassword" >
                          <span class="form-group__message"></span>
                    </div>
                 </div>

            </div>
       
        
            <div class="row">
                 <div class="col-md-12">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Xác Nhận Mật Khẩu</label>
                         <input type="password" class="form-control" placeholder="Xác nhận mật khẩu" name="confirm_password" id="confirmPassword" >
                         <span class="form-group__message"></span>
                    </div>
                 </div>

            </div>
           
            <div class="row">
                 <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;margin-bottom:36px;">Xác Nhận</button>
                 </div>

            </div>

    </form>
    </div>
</section>

<script src="../assets/script/validator.js"></script>
   
   <script>
       Validator({
           form: '#validatorAccountPage',
           formGroupSelector: '.mb-3',
           errorSelector: '.form-group__message',
           rules: [
              Validator.isRequired('#nameCus'),
              Validator.isRequired('#phoneCus'),
              Validator.isEmail('#emailCus','<i class="fas fa-exclamation-triangle warn_icon"></i>Email không chính xác'),
           ]
          
       });
       
       const oldPassword = document.getElementById('oldPassword');
       oldPassword.onchange = function(){
        Validator({
           form: '#validatorAccountPage',
           formGroupSelector: '.mb-3',
           errorSelector: '.form-group__message',
           rules: [
              Validator.isPassword('#oldPassword'),
              Validator.isPassword('#newPassword'),
              Validator.isConfirmed('#confirmPassword',function(){
                   return document.querySelector('#validatorAccountPage #newPassword').value;
               },'<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không trùng khớp')
           ]
          
       });
       };
       const newPassword = document.getElementById('newPassword');
       newPassword.onchange = function(){
        Validator({
           form: '#validatorAccountPage',
           formGroupSelector: '.mb-3',
           errorSelector: '.form-group__message',
           rules: [
              Validator.isPassword('#oldPassword'),
              Validator.isPassword('#newPassword'),
              Validator.isConfirmed('#confirmPassword',function(){
                   return document.querySelector('#validatorAccountPage #newPassword').value;
               },'<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không trùng khớp')
           ]
        });
       };

       const confirmPassword = document.getElementById('confirmPassword');
       confirmPassword.onchange = function(){
        Validator({
           form: '#validatorAccountPage',
           formGroupSelector: '.mb-3',
           errorSelector: '.form-group__message',
           rules: [
              Validator.isPassword('#oldPassword'),
              Validator.isPassword('#newPassword'),
              Validator.isConfirmed('#confirmPassword',function(){
                   return document.querySelector('#validatorAccountPage #newPassword').value;
               },'<i class="fas fa-exclamation-triangle warn_icon"></i>Mật khẩu không trùng khớp')
           ]
          
       });
       }
  </script>