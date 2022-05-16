<?php 
include_once './delete.php';
if(isset($_SESSION['id_customer'])){
  $id_customer = $_SESSION['id_customer'];
  $sql = "SELECT * FROM customeraddress WHERE id_customer = '$id_customer'";
  $query = mysqli_query($conn, $sql);
  if(isset($_POST['id_delete'])){
    $location = $_GET['page_layout'];
    $id_delete = $_POST['id_delete'];
    $sql = "CALL xoaData('$location',$id_delete,'id_address')";
   if(mysqli_query($conn,$sql)){
        $_SESSION['title'] = "Xóa Thành Công!";
        $_SESSION['icon']= "success";
        if(isset($_POST['queryToBack'])){
            $url = "index.php?page_layout=" .$_GET['page_layout'];
            $url .="&id=" .$_POST['queryToBack'];
        }else{
            $url = "index.php?page_layout=" .$_GET['page_layout'];
        }
        if(headers_sent()){
           die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
    } else {
        $_SESSION['title'] = "Xóa Thất Bại!";
        $_SESSION['icon']= "error";
        $conn -> rollback();
        if(isset($_POST['queryToBack'])){
            $url = "index.php?page_layout=" .$_GET['page_layout'];
            $url .="&id=" .$_POST['queryToBack'];
        }else{
            $url = "index.php?page_layout=" .$_GET['page_layout'];
        }
        if(headers_sent()){
           die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
       
       // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
          <h4>Thông Tin Địa Chỉ</h4>
        </div>

            <div class="row">
                 <div class="col-md-12">
                    <table class="table">
                    
                        <thead>
                          <tr>
                            <th scope="col">Địa Chỉ</th>
                            <th scope="col">Tên Người Nhận</th>
                            <th scope="col">Số Điện Thoại Người Nhận</th>
                            <th scope="col">Tác Vụ</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                         if(mysqli_num_rows($query) > 0 && mysqli_num_rows($query) <=3){
                         
                          while($row = mysqli_fetch_array($query)){
                
                         ?>
                          <tr>
                               <td ><?php echo $row['address_receive']; ?></td>
                               <td><?php echo $row['name_receive']; ?></td>
                               <td><?php echo $row['phone_receive']; ?></td>
                               <td style="display:flex">
                                <a href="index.php?page_layout=editAddress&id=<?php echo $row['id_address'];?>" style="color:black; text-decoration:none; margin-right:10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                      <input type="hidden" class ="query" value ="<?php echo $row['id_address'];?>" name="id_delete">
                                      <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></button>
                                </form>
                              </td>
                               
                            </tr>
                         
                          <?php }
                          }else{
                            
                           ?>
                            <tr>
                              <th scope="row">Chưa Có Địa Chỉ Giao Hàng</th>
                           
                            </tr>
                            <?php }?>
                        </tbody>
                     
                     
                      </table>
                 </div>
    
                
            </div>
       
        
      
         
            <div class="row">
                 <div class="col-md-12">
                   <a href = "index.php" class="btn btn-primary " style="margin-top:12px;margin-bottom:32px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Trở Về Trang Chủ</a>
                   <?php if(mysqli_num_rows($query) <=3){?>
                    <a href="index.php?page_layout=addAddress" class="btn btn-primary" style="background-color: #212529;margin-top:12px;margin-bottom:36px;">Thêm Địa Chỉ</a>
                    <?php }else{?>
                      <a href="index.php?page_layout=addAddress" class="btn btn-primary" style="pointer-events: none; background-color: #AAAAAA">Thêm Địa Chỉ</a>
                    <?php }?>
                   
             
                 </div>

            </div>

   
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
  </script>