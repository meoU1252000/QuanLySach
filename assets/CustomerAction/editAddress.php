<?php 
if(isset($_REQUEST['id'])){
    $id_address = $_REQUEST['id'];
    $query =mysqli_query($conn,"SELECT * FROM customeraddress WHERE id_address = '$id_address'") ;
    $row = mysqli_fetch_array($query);
    if(isset($_POST['address_customer']) && isset($_POST['name_customer']) && isset($_POST['phone_customer'])){
        $address = $_POST['address_customer'];
        $name = $_POST['name_customer'];
        $phone_customer = $_POST['phone_customer'];
        $sql = "UPDATE customeraddress SET address_receive = '$address', name_receive = '$name', phone_receive = '$phone_customer' where id_address = '$id_address'";
        if(mysqli_query($conn, $sql)){
            $_SESSION['title'] = "Cập Nhật Địa Chỉ Giao Hàng Thành Công!";
            $_SESSION['icon']= "success";
            $url = "index.php?page_layout=customeraddress";
            if(headers_sent()){
                die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                 header ("location: $url");
                 die();
            }
        }else{
            $_SESSION['title'] = "Cập Nhật Địa Chỉ Giao Hàng Thất Bại !";
            $_SESSION['icon']= "error";
            //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
            $conn -> rollback();
            $url = "index.php?page_layout=customeraddress";
            if(headers_sent()){
                die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                 header ("location: $url");
                 die();
            }
        }
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
          <h4>Cập Nhật Địa Chỉ Giao Hàng</h4>
        </div>
        <form action="#" method="POST" enctype="multipart/form-data" id = "validatorAccountPage">
            <div class="row">
                 <div class="col-md-6">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Họ Và Tên Người Nhận Hàng</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào họ tên của người nhận hàng" name="name_customer" id="nameCus" value="<?php echo $row['name_receive'] ?>">
                         <span class="form-group__message"></span>
                    </div>
                 </div>
    
                 <div class="col-md-6">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Số Điện Thoại Người Nhận Hàng</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào số điện thoại người nhận hàng" name="phone_customer" id="phoneCus" value="<?php echo $row['phone_receive'] ?>" >
                          <span class="form-group__message"></span>
                    </div>
                </div>
            </div>
       
        
      
            <div class="row">
                 <div class="col-md-12">
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Địa Chỉ Nhận Hàng</label>
                         <input type="text" class="form-control"  placeholder="Nhập vào địa chỉ nhận hàng" name="address_customer" id="addressCus" value="<?php echo $row['address_receive'] ?>">
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
              Validator.isRequired('#addressCus'),
           ]
          
       });
  </script>