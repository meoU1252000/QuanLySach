<?php 
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    include_once './alert.php';
    if(in_array("5", $_SESSION['roleStaff'], true)){
        $result = mysqli_query($conn, "SELECT * from codediscount");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_code')";
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
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Mã Giảm Giá</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Mã Giảm Giá
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Phần Trăm Giảm</th>
                                            <th>Ngày Bắt Đầu Sự Kiện</th>
                                            <th>Ngày Kết Thúc Sự Kiện</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Phần Trăm Giảm</th>
                                            <th>Ngày Bắt Đầu Sự Kiện</th>
                                            <th>Ngày Kết Thúc Sự Kiện</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_code']; ?></td>
                                            <td> <?php echo $row['code_event']; ?></td>
                                            <td> <?php echo $row['discount_value']; ?></td>
                                            <td><?php echo $row['date_start'];?></td>
                                            <td><?php echo $row['date_end'];?></td>
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=editCode&id=<?php echo $row['id_code'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                 <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                     <input type="hidden" class ="query" value ="<?php echo $row['id_code'];?>" name="id_delete">
                                                     <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                  </form>
                                             </td>
                                        </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                    
                                </table>
                                <a href = "index.php?page_layout=addCode" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        
                        </div>
                        
                 </div>