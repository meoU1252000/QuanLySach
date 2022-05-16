<?php 
include_once './delete.php';
if(isset($_SESSION['id_customer'])){
  $id_customer = $_SESSION['id_customer'];
  $sql = "SELECT * FROM orders WHERE id_customer = '$id_customer'";
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
          <h4>Thông Tin Đơn Hàng</h4>
        </div>

            <div class="row">
                 <div class="col-md-12">
                    <table class="table">
                    
                        <thead>
                          <tr>
                            <th scope="col">Mã Đơn Hàng</th>
                            <th scope="col">Ngày Đặt Hàng</th>
                            <th scope="col">Ngày Giao Hàng Dự Kiến</th>
                            <th scope="col">Ngày Giao Hàng Thực Tế</th>
                          
                            <th scope="col">Tình Trạng Đơn Hàng</th>
                            <th scope="col">Xem Chi Tiết Đơn Hàng</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                         if(mysqli_num_rows($query) > 0 ){
                          while($row = mysqli_fetch_array($query)){
                         ?>
                          <tr>
                               <td style="text-align:center"><?php echo $row['id_order'] ;?></td>
                               <td style="text-align:center"><?php echo $row['date_order'] ;?></td>
                               <td style="text-align:center"><?php $date = $row['date_order']; echo date('Y-m-d', strtotime($date. ' + 5 days')); ?></td>
                               <td style="text-align:center"><?php echo $row['date_delivery']; ?></td>
                               <td style="text-align:center"><?Php  echo $row['order_status']; ?></td>
                               <td style="text-align:center">
                                 <a href="index.php?page_layout=orderDetails&id=<?php echo $row['id_order'];?>" style="color:black; text-decoration:none; margin-right:10px;"><i class="fa-solid fa-exclamation"></i></a>
                              </td>
                               
                            </tr>
                         
                          <?php }
                          }else{
                            
                           ?>
                            <tr>
                              <th scope="row">Chưa Có Đơn Hàng nào</th>
                           
                            </tr>
                            <?php }?>
                        </tbody>
                     
                     
                      </table>
                 </div>
    
                
            </div>
       
         
            <div class="row">
                <div class="col-md-12">
                    <a href = "index.php" class="btn btn-primary " style="background-color: #212529;margin-top:12px;margin-bottom:32px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Trở Về Trang Chủ</a>
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