<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    include_once './alert.php';
    if(in_array("1", $_SESSION['roleStaff'], true)){
        $result = mysqli_query($conn, "SELECT * from viewstaff");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_staff')";
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
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Nhân Viên</li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Nhân Viên
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Họ Tên</th>
                                            <th>Chức Vụ</th>
                                            <th>Địa Chỉ</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Email</th>
                                            <th>Ghi Chú</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Họ Tên</th>
                                            <th>Chức Vụ</th>
                                            <th>Địa Chỉ</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Email</th>
                                            <th>Ghi Chú</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $row['staff_id']; ?></td>
                                            <td> <?php echo $row['staff_name']; ?></td>
                                            <td> <?php echo $row['staff_position']; ?></td>
                                            <td><?php echo $row['staff_address']; ?></td>
                                            <td><?php echo $row['staff_phone']; ?></td>
                                            <td>
                                                <?php 
                                                    $id_nv = $row['staff_id'];
                                                    $query = mysqli_query($conn,"SELECT * from staffaccount where id_staff = '$id_nv'");
                                                    if(mysqli_num_rows($query) > 0){
                                                        $row_account = mysqli_fetch_array($query);
                                                        echo $row_account['email_staff']; 
                                                    }
                                                ?>
                                            </td>
                                            <td> <?php echo $row['staff_note']; ?></td>
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=editStaff&id=<?php echo $row['staff_id'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                 <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                     <input type="hidden" class ="query" value ="<?php echo $row['staff_id'];?>" name="id_delete">
                                                     <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                  </form>
                                             </td>
                                        </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                    
                                </table>
                                <a href = "index.php?page_layout=addStaff" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        
                        </div>
                        
                 </div>




  
