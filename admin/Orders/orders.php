<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    include_once './alert.php';
    if(in_array("2", $_SESSION['roleStaff'], true)){
        $result = mysqli_query($conn, "SELECT * from vieworders order by id_order");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_order')";
           if(mysqli_query($conn,$sql)){
                $_SESSION['status'] = "Xóa Thành Công!";
                $_SESSION['status_code']= "success";
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
                $_SESSION['status'] = "Xóa Thất Bại!";
                $_SESSION['status_code']= "error";
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
        echo '<script language="javascript">';
        echo 'alert("Bạn không có quyền truy cập vào trang này")';
        echo '</script>';
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
        }
    }
}
?>


            
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Đơn Hàng</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Đơn Hàng
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nhân Viên Phụ Trách</th>
                                            <th>Địa Chỉ Giao Hàng</th>
                                            <th>Tên Người Nhận</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Ngày Đặt Hàng</th>
                                            <th>Ngày Giao Hàng</th>
                                            <th>Tình Trạng Đơn Hàng</th>
                                            <th>Tổng Giá Trị Đơn Hàng</th>
                                            <th>Ghi Chú</th>
                                             <th>Chi Tiết Đơn Hàng</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>ID</th>
                                            <th>Nhân Viên Phụ Trách</th>
                                            <th>Địa Chỉ Giao Hàng</th>
                                            <th>Tên Người Nhận</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Ngày Đặt Hàng</th>
                                            <th>Ngày Giao Hàng</th>
                                            <th>Tình Trạng Đơn Hàng</th>
                                            <th>Tổng Giá Trị Đơn Hàng</th>
                                            <th>Ghi Chú</th>
                                             <th>Chi Tiết Đơn Hàng</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_order']; ?></td>
                                            <td> <?php echo $row['name_staff']; ?></td>
                                            <td> <?php echo $row['address_receive']; ?></td>
                                            <td> <?php echo $row['name_receive']; ?></td>
                                            <td> <?php echo $row['phone_receive']; ?></td>
                                            <td><?php echo $row['code_event']; ?></td>
                                            <td> <?php echo $row['date_order']; ?></td>
                                            <td> <?php echo $row['date_delivery']; ?></td>
                                            <td> <?php echo $row['order_status']; ?></td>
                                            <td> <?php echo number_format($row['total_price']); ?></td>
                                            <td> <?php echo $row['note_orders']; ?></td>
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=orderDetails&id=<?php echo $row['id_order'];?>" class ="action_edit"><i class="fas fa-external-link-alt icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=editOrder&id=<?php echo $row['id_order'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                 <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                     <input type="hidden" class ="query" value ="<?php echo $row['id_order'];?>" name="id_delete">
                                                     <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                  </form>
                                             </td>
                                        </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                    
                                </table>
                                <a href = "index.php" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Về Trang Chủ</a>
                            </div>
                        
                        </div>
                        
                 </div>




  
